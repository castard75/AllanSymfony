<?php

namespace App\Command;

use App\Entity\Employeesdevices;
use App\Entity\Equipments;
use App\Entity\Gabarit;
use App\Entity\Gabarititems;
use App\Entity\Interventions;
use App\Entity\Interventionsitems;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:import',
)]
class Import extends Command
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
            ->setDescription('Import')
            ->setHelp('');
    }

    private $ListeEmploye = array("Moursalina Ahamada" => 2, "Mickael Fabre" => 4, "Philippe Mithridate" => 3);

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $Fichier = str_replace('import.php', '', $_SERVER['DOCUMENT_ROOT'])."import.csv";
        $taille = 2048;
        $fichier_csv = fopen("erreur-import.csv", "w+");
        if (($handle = fopen($Fichier, 'r')) !== FALSE) {
            while (($tab_1 = fgetcsv($handle, $taille, ';', '"')) !== FALSE) {
                $Technicien = trim($tab_1[0]);
                $Appareil = str_replace("8_", "8-", str_replace("TJF", "TJF_", str_replace("I.", "I-", str_replace("EP.", "", str_replace("AM.", "", str_replace("EPMR", "", str_replace("VO/", "", str_replace("MC/", "", str_replace("ASC/", "", str_replace(" ", "", trim($tab_1[1])))))))))));
                if(trim($tab_1[1]) == "EP.5016"){
                    $Appareil = "EP5016";
                }elseif(trim($tab_1[1]) == "AM.408269"){
                    $Appareil = "AM408269";
                }elseif(trim($tab_1[1]) == "AM.450254"){
                    $Appareil = "AM450254";
                }elseif(trim($tab_1[1]) == "AM.450391"){
                    $Appareil = "AM450391";
                }elseif(trim($tab_1[1]) == "TJF1911062-A"){
                    $Appareil = "TJF1911062-A";
                }
                $Date = trim($tab_1[2]);
                if(isset($this->ListeEmploye[$Technicien])) {
                    $ListeAppareil = $this->entityManager->getRepository(Equipments::class)
                        ->createQueryBuilder('u')
                        ->where('u.reference=:reference AND u.origineid=:origineid')
                        ->getQuery()
                        ->setParameter("reference", $Appareil)
                        ->setParameter("origineid", $this->entityManager->getReference('App\Entity\Myconnectors', 2))
                        ->execute();
                    $cpt = 0;
                    foreach($ListeAppareil as $valinter) {
                        $cpt++;
                        $tp_entity = new Employeesdevices();
                        $tp_entity
                            ->setDeviceId($valinter->getId())
                            ->setRefDevice($valinter->getReference())
                            ->setLabelDevice($valinter->getName())
                            ->setStatusDevice(1)
                            ->setEmployeeId($this->ListeEmploye[$Technicien] );
                        $this->entityManager->persist($tp_entity);

                        if($Date != "") {
                            $occurence = $this->entityManager->getRepository(Equipments::class)
                                ->findOneBy(array(
                                    "id" => $valinter->getId(),
                                ));

                            $occurence
                                ->setStatus(1)
                                ->setStartserviceat(new DateTimeImmutable($Date));
                            $this->entityManager->persist($occurence);

                            if($occurence->getTypeid() != null) {
                                $Liste = $this->entityManager->getRepository(gabarit::class)->createQueryBuilder('m')->where('m.typeii = ' . $occurence->getTypeid()->getId())->getQuery()->execute();
                                foreach ($Liste as $val) {
                                    $IdGabarit = $val->getId();
                                    $Recurrence = $val->getRecurrence();
                                    $MyDate = explode("-", $Date);
                                    $Jour = (int)$MyDate[2] + (int)$Recurrence;
                                    sscanf(date("Y-m-d H:i:s", mktime(0, 0, 0, $MyDate[1], $Jour, $MyDate[0])), "%4s-%2s-%2s %2s:%2s:%2s", $an2, $moi2, $jour2, $heur2, $min2, $sec2);

                                    $tp_entity = new Interventions();
                                    $tp_entity
                                        ->setState("1")
                                        ->setMode("2")
                                        ->setDate(new DateTimeImmutable($an2 . "-" . $moi2 . "-" . $jour2))
                                        ->setCustomerid($this->entityManager->getReference('App\Entity\Customers', $occurence->getCustomerid()->getId()))
                                        ->setAppareilid($this->entityManager->getReference('App\Entity\Equipments', $occurence->getId()))
                                        ->setGabaritid($this->entityManager->getReference('App\Entity\Gabarit', $IdGabarit))
                                        ->setEmployeeid($this->entityManager->getReference('App\Entity\Employees', $this->ListeEmploye[$Technicien]))
                                        ->setOrigineid($this->entityManager->getReference('App\Entity\Myconnectors', 2));
                                    $this->entityManager->persist($tp_entity);
                                    $this->entityManager->flush();
                                    $NewId = $tp_entity->getId();

                                    $Liste2 = $this->entityManager->getRepository(gabarititems::class)->createQueryBuilder('m')->where('m.gabaritid = ' . $IdGabarit)->getQuery()->execute();
                                    foreach ($Liste2 as $val2) {
                                        $tp_entity2 = new Interventionsitems();
                                        $tp_entity2
                                            ->setInterventionid($NewId)
                                            ->setParentid($val2->getId())
                                            ->setLieeid($val2->getClasseid())
                                            ->setName($val2->getLabel());
                                        $this->entityManager->persist($tp_entity2);
                                    }
                                }
                            }
                        }

                        $this->entityManager->flush();
                    }
                    if($cpt == 0){
                        fputcsv($fichier_csv, array(trim($tab_1[0]), trim($tab_1[1]), trim($tab_1[2])), ";");
                        //echo $Technicien." - ".$Appareil." - ".$Date."\r\n";
                    }
                }
            }
        }
        fclose($fichier_csv);
        return Command::SUCCESS;
    }
}