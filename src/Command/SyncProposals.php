<?php
namespace App\Command;
use App\Entity\Estimations;
use App\Entity\Customers;
use App\Entity\Interventions;
use App\Entity\Estimationsitems;
use App\Entity\Myconnectors;


use DateTimeImmutable;
use Symfony\Component\Console\Attribute\AsCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:syncproposals', 'Sync propositions')]
class SyncProposals extends Command {

    protected static $defaultName = 'app:syncproposals';
    private $entityManager;
    private $ClientHTTP;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setDescription('Gestion des propositions');
    }

    protected function execute(InputInterface $input,OutputInterface $output){


 $io = new SymfonyStyle($input, $output);
 $ListeConnector = $this->entityManager->getRepository(Myconnectors::class)->createQueryBuilder('u')->where('u.url IS NOT NULL')->getQuery()->execute();
 foreach ($ListeConnector as $Val){
 
    $OrigineId = $Val->getId();
    $UrlApi = $Val->getUrl();
    $TokenApi = $Val->getLogin();

   
    $this->recupererListePropositions($OrigineId, $UrlApi, $TokenApi);
}

return Command::SUCCESS;
 
}

 private function recupererListePropositions($OrigineId, $UrlApi, $TokenApi) { 

    $em = $this->entityManager;

    $this->ClientHTTP = HttpClient::create()->withOptions([
        'headers' => [
            'Accept' => 'application/json',
            'DOLAPIKEY' => $TokenApi
        ]
    ]);
    $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi."/proposals?sortfield=t.rowid&sortorder=ASC&limit=100000");
    if($RequeteApi->getStatusCode() == 200){
        $content = json_decode($RequeteApi->getContent(), true);
       
        foreach($content as $resultat)
        {

        
            $Id = trim($resultat['id']);
            $Reference = NULL;
    

            if(trim($resultat['ref']) != ""){
                $Reference = trim($resultat['ref']);
            }
            
            $Desc = Null;
            
            if(isset($resultat['lines'][0]['desc']) && trim($resultat['lines'][0]['desc'] != "")){

                $Desc = $resultat['lines'][0]['desc'];
            }
            $Qty = Null;
            
            if( isset($resultat['lines'][0]['qty']) && trim($resultat['lines'][0]['qty'] != "")){

                $Qty = $resultat['lines'][0]['qty'];
            }


            $ReferenceBr = NULL;
            if(trim($resultat['ref_client']) != ""){
                $ReferenceBr = trim($resultat['ref_client']);
            }
            
            $CustomerId = NULL;
            if(trim($resultat['socid']) != ""){
                $occurence2 = $em->getRepository(Customers::class)
                    ->findOneBy(array(
                        "dolid" => trim($resultat['socid']),
                        "origineid" => $OrigineId
                    ));
                if($occurence2) {
                    $CustomerId = $em->getReference('App\Entity\Customers', $occurence2->getId());
                }
            }
            $State = NULL;
            if(trim($resultat['statut']) != ""){
                $State = trim($resultat['statut']);
            }
            $conditionReglement = NULL;
            if(trim($resultat['cond_reglement_id']) != ""){
            $conditionReglement = trim($resultat['cond_reglement_id']);

            }
            $Date = NULL;
            if(trim($resultat['date_creation']) != ""){
                $Date = new DateTimeImmutable(date('Y-m-d', trim($resultat['date_creation'])));
            }
            $DateUpdate = NULL;
            if(trim($resultat['date_modification']) != ""){
                $DateUpdate = new DateTimeImmutable(date('Y-m-d H:m:s', trim($resultat['date_modification'])));
            }

      



            $DateLimit = NULL;
            if(trim($resultat['fin_validite']) != ""){
                $DateLimit = new DateTimeImmutable(date('Y-m-d H:m:s', trim($resultat['fin_validite'])));
            }

            $DateValidation = NULL;
            if(trim($resultat['date_validation']) != ""){
                $DateValidation = new DateTimeImmutable(date('Y-m-d H:m:s', trim($resultat['date_validation'])));
            }
            $TotalHT = NULL;
            if(trim($resultat['total_ht']) != ""){
                $TotalHT = trim($resultat['total_ht']);
            }
            $TotalTVA = NULL;
            if(trim($resultat['total_tva']) != ""){
                $TotalTVA = trim($resultat['total_tva']);
            }
            $TotalTTC = NULL;
            if(trim($resultat['total_ttc']) != ""){
                $TotalTTC = trim($resultat['total_ttc']);
            }
            $NotePublic = NULL;
            if(trim($resultat['note_public']) != ""){
                $NotePublic = trim($resultat['note_public']);
            }
            $NotePrive = NULL;
            if(trim($resultat['note_private']) != ""){
                $NotePrive = trim($resultat['note_private']);
            }
            $State = NULL;
            if(trim($resultat['statut']) != ""){
                $State = trim($resultat['statut']);
            }


            $occurence = $em->getRepository(Estimations::class)
                ->findOneBy(array(
                    "extendid" => $Id,
                    "origineid" => $OrigineId
                ));

             
                $occurenceinterv = $em->getRepository(Interventions::class)
                ->findOneBy(array(
                    "customerid" => $CustomerId,
                    "refextid" => $Id,
                   
                ));

             
            
                    if (is_null($occurence)) {
                        $tp_entity =  (new Estimations())
                            ->setReferencebr($ReferenceBr)
                            ->setReference($Reference)
                            ->setState($State)
                            ->setDate($Date)       
                            ->setTotalht($TotalHT)
                            ->setCustomerid($CustomerId)
                            ->setTotaltva($TotalTVA)
                            ->setTotalttc($TotalTTC)
                            ->setNotepublic($NotePublic)
                            ->setNoteprive($NotePrive)
                            ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                            ->setExtendid($Id)
                            ->setDateValidation($DateValidation)
                            ->setTransfert("0");
                        $em->persist($tp_entity);

                   
                      
                        if(is_null($occurenceinterv) && $DateValidation !== "" && $DateValidation !== null && $CustomerId !== "" && $CustomerId !== null   ){
                        
                            $tp_intervention = (new Interventions())
                            ->setReferencebr($ReferenceBr)
                            ->setReference($Reference)
                            ->setDate($DateValidation)
                            ->setRefextid($Id)
                            ->setCustomerid($CustomerId)
                            ->setState(1)
                            ->setNotepublic($NotePublic)
                            ->setMode(0);
                        
                            $em->persist($tp_intervention);
                                                    }
                            

                        $tp_estimationitems =  (new Estimationsitems())
                        ->setReference($Reference)
                        ->setQuantity($Qty)
                        ->setName($Desc)
                        ->setEstimationid($tp_entity);
                        $em->persist($tp_estimationitems);


                    } else {
                      
                        if($DateValidation !== "" && $DateValidation !== null && $CustomerId !== "" && $CustomerId !== null   ){
                        
                      
                          

                            $occurenceinterv
                            ->setReferencebr($ReferenceBr)
                            ->setReference($Reference)
                            ->setDate($DateValidation)
                            ->setCustomerid($CustomerId)
                            ->setRefextid($Id)
                            ->setState(1)
                            ->setNotepublic($NotePublic)
                            ->setMode(0);
                            
                            $em->persist($occurenceinterv);
                            
                                                    }
                            

                        $occurence
                            ->setReferencebr($ReferenceBr)
                            ->setReference($Reference)
                            ->setState($State)
                            ->setDate($Date)
                            ->setDateValidation($DateValidation)
                            ->setTotalht($TotalHT)
                            ->setCustomerid($CustomerId)
                            ->setTotaltva($TotalTVA)
                            ->setTotalttc($TotalTTC)
                            ->setNotepublic($NotePublic)
                            ->setNoteprive($NotePrive)
                            ->setOrigineid($em->getReference('App\Entity\Myconnectors', $OrigineId))
                            ->setTransfert("0")
                            ->setExtendid($Id);
                        $em->persist($occurence);

                        $occurenceitems = $em->getRepository(Estimationsitems::class)
                        ->findOneBy(array(
                            "estimationid" => $occurence->getId(),
                           
                        ));
                     
                        
                        $occurenceitems
                        ->setReference($Reference)
                        ->setQuantity($Qty)
                        ->setName($Desc)
                        ->setEstimationid($occurence);
                        $em->persist($occurenceitems);


                        
                    }
                    $em->flush();
             
            
                
        }
    }


 }



}




