<?php

namespace App\Command;

use App\Entity\Companies;
use App\Entity\Myconnectors;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:synccompanies',
)]
class SyncCompanies extends Command
{
    private $entityManager;
    private $ClientHTTP;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName('SyncCompanies')
            ->setDescription('Synchronisation des companies')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ListeConnector = $this->entityManager->getRepository(Myconnectors::class)->createQueryBuilder('u')->where('u.url IS NOT NULL')->getQuery()->execute();
        foreach($ListeConnector as $val){
            //Récupere les infos Doli
            $OrigineId = $val->getId();
            $UrlApi = $val->getUrl();
            $TokenApi = $val->getLogin();

            $this->recupererListeCompanies($OrigineId, $UrlApi, $TokenApi);
        }

        return Command::SUCCESS;
    }

    private function recupererListeCompanies($OrigineId, $UrlApi, $TokenApi){
        $em = $this->entityManager;

        $this->ClientHTTP = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $TokenApi
            ]
        ]);

        $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi."/setup/company");
        if($RequeteApi->getStatusCode() == 200){
            $content = json_decode($RequeteApi->getContent(), true);
            
            $Id = trim($content['id']);
            
            $Name = NULL;
            if(trim($content['name']) != ""){
                $Name = trim($content['name']);
            }
            $Address = NULL;
            if(trim($content['address']) != ""){
                $Address = trim($content['address']);
            }
            $Email = NULL;
            if(trim($content['email']) != ""){
                $Email = trim($content['email']);
            }
            $Phone = NULL;
            if(trim($content['phone']) != ""){
                $Phone = trim($content['phone']);
            }
            $Siret = NULL;
            if(trim($content['siret']) != ""){
                $Siret = trim($content['siret']);
            }
            $Siren = NULL;
            if(trim($content['siren']) != ""){
                $Siren = trim($content['siren']);
            }
            $PostCode = NULL;
            if(trim($content['zip']) != ""){
                $PostCode = trim($content['zip']);
            }
            $NameCity = NULL;
            if(trim($content['town']) != ""){
                $NameCity = trim($content['town']);
            }
            $MyConnectorId = NULL;
            if(trim($content['id']) != ""){
                $occurence2 = $em->getRepository(Myconnectors::class)
                    ->findOneBy(array(
                        "id" => $OrigineId,
                    ));
                if($occurence2){
                    $MyConnectorId = $occurence2->getId();
                }
            }

            $occurence = $em->getRepository(Companies::class)
                ->findOneBy(array(
                    "id" => $Id,
                ));
            
            if(is_null($occurence)){
                $tp_entity = new Companies();
                $tp_entity
                    ->setName($Name)
                    ->setAddress($Address)
                    ->setEmail($Email)
                    ->setFixphone($Phone)
                    ->setSiret($Siret)
                    ->setSiren($Siren)
                    ->setPostcode($PostCode)
                    ->setNamecity($NameCity)
                    ->setMyconnectorid($em->getReference('App\Entity\Myconnectors', $MyConnectorId));
                $em->persist($tp_entity);
            }else{
                $occurence
                    ->setName($Name)
                    ->setAddress($Address)
                    ->setEmail($Email)
                    ->setFixphone($Phone)
                    ->setSiret($Siret)
                    ->setSiren($Siren)
                    ->setPostcode($PostCode)
                    ->setNamecity($NameCity)
                    ->setMyconnectorid($em->getReference('App\Entity\Myconnectors', $MyConnectorId));
                $em->persist($occurence);
            }
            $em->flush();
        }
    }
}