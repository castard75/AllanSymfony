<?php

namespace App\Command;

use DateTimeImmutable;



// use App\Entity\Voxwide;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Cdr;
use App\Entity\Sda;
use App\Entity\ParamSDA;
use App\Entity\IndicatifSda;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use League\Csv\Reader;
use Doctrine\ORM\EntityManagerInterface;


class ipDirectionCommand extends Command
{

    protected static $defaultName = 'app:ip';

    public function __construct(
        ParameterBagInterface $parameterBag,
        EntityManagerInterface $em
    ) {
        $this->parameterBag = $parameterBag;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Gestion CSV ');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Créer un objet SymfonyStyle
        $io = new SymfonyStyle($input, $output);

        // Récupérer le répertoire des fichiers CSV
        $dir = __DIR__ . '/../../public/uploads/imports/ipDirection';
        $dir2 = __DIR__ . '/../../public/uploads/processed/';


        // Récupérer la liste des fichiers
        $files = scandir($dir);

        // Pour chaque fichier du répertoire des fichiers CSV (var/imports)
        foreach ($files as $file) {
            // Si le fichier est un fichier CSV (extension .csv) alors on le traite avec la méthode csvProcessing()
            if (pathinfo($file, PATHINFO_EXTENSION) == 'csv') {
                // Appel de la méthode csvProcessing() avec le chemin du fichier CSV en paramètre ensuite on rentre dans le else si il y a pas de soucis
                $processing = $this->csvProcessing($dir . '/' . $file);

                // Si le traitement du fichier CSV a échoué alors on affiche un message d'erreur et on arrête le script sinon on déplace le fichier CSV dans le répertoire var/imports/processed
                if (!$processing) {
                    $io->error('Erreur lors du traitement du fichier ' . $file);
                    return 1;
                } else {
                    // // Récupérer la date du jour
                    // $filename_date = new \DateTime();

                    // // Récupère l'extension du fichier
                    // $extension = pathinfo($file, PATHINFO_EXTENSION);

                    // // Récupère le nom de fichier sans extension " ex : titre"
                    // $baseName = basename($file, '.' . $extension);

                    // // Déplacer le fichier CSV dans le répertoire var/imports/processed avec un nom de fichier composé du nom de fichier d'origine, de la date du jour et de l'extension
                    // rename($dir . '/' . $file, $dir2 . $baseName .  '-' . $filename_date->format('Y_m_d_H_i_s') . '.' . $extension);


                    // Afficher un message de succès
                    $io->success('File ' . $file . ' processed successfully');
                }
            }
        }



        return 0;
    }

    public function csvProcessing(string $pathFile): bool
    {

        try {
            // Créer un objet Reader avec le chemin du fichier CSV en paramètre et le mode 'r' pour lecture seule
            $csv = Reader::createFromPath($pathFile, 'r');
            $filename_date = new \DateTime();
            $filename_string = $filename_date->format('Y-m-d H:i:s');
            $dateString = "01-01-2023 03:28:52";
            $format = "d-m-Y H:i:s";
            $createdDateImmutable = DateTimeImmutable::createFromFormat($format, $dateString);

            // Définir le délimiteur
            $batchSize = 20;
            $count = 0;
            $checkPhoneNumber = [];


            // Pour chaque ligne du fichier CSV
            foreach ($csv as $col) {


                $data = $col[0];


                $explodesData = explode(";", $data);


                $dateImmutable = DateTimeImmutable::createFromFormat($format, $explodesData[2]);
                $appelant = $explodesData[0];
                $appeler = $explodesData[1];
                $date = $explodesData[2];
                $durée = $explodesData[3];
                $price = $explodesData[5];
                $trunk = $explodesData[11];
                $trunkConverted = intval($trunk);



                // Créer un nouvel objet Voxwide

                $voxwide = (new CDR())
                    ->setSiptrunk($trunkConverted)
                    ->setCaller($explodesData[7])
                    ->setCalled($explodesData[1])
                    ->setDateAt($createdDateImmutable)
                    ->setOrigin("IpDirection")
                    ->setPrice($explodesData[5])
                    ->setAnomaly(false)
                    ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                    ->setOriginId("0")
                    ->setDevise("Eur")
                    ->setstatus("1")
                    ->setEtat("0")

                    ->setActivate("0");


                // // // Condition pour vérifier si le numéro est correcte dans ma boucle 
                if ($this->checkNumberLength($explodesData[1])) {
                    $voxwide->setAnomaly(true)
                        ->setComment("Numéro incomplet");
                }
                // Vérifie s'il y a l'indicatif "+262" dans le numéro
                if (substr_count($explodesData[1], "692")) {

                    $voxwide->setType(1);
                } elseif (substr_count($explodesData[1], "693")) {

                    $voxwide->setType(1);
                } elseif (substr_count($explodesData[1], "336")) {

                    $voxwide->setType(1);
                } elseif (substr_count($explodesData[1], "639")) {

                    $voxwide->setType(1);
                } elseif (substr_count($explodesData[1], "6")) {

                    $voxwide->setType(1);
                } elseif (substr_count($explodesData[1], "7")) {

                    $voxwide->setType(1);
                } else {

                    $voxwide->setType(0);
                }


                // // // SetternewparamsSda

                $concat = "+" . $explodesData[7];

                // // // Enregistrer le produit dans la base de données
                $this->em->persist($voxwide);












                if (!in_array($voxwide->getCaller(), $checkPhoneNumber)) {

                    $paramsSdaName = $this->em->getRepository(ParamSDA::class)->findOneBy([
                        "name" => $voxwide->getCaller()

                    ]);

                    //Si le numéro est pas dans paramSda
                    if (!$paramsSdaName instanceof ParamSDA) {
                        //On met le numéro dans le tableau
                        $checkPhoneNumber[] = $voxwide->getCaller();


                        //Trouver le bon indicatif
                        $caller = $voxwide->getCaller();

                        $allIndicatifs = $this->em->getRepository(IndicatifSda::class)->findAll();


                        foreach ($allIndicatifs as $tabIndicatif) {

                            $indicatifTabValue = $tabIndicatif->getIndicatif();
                            $prefixe = $tabIndicatif->getPrefixe();


                            //On affiche l'indicatif de chaque numéro
                            if (substr_count($explodesData[7], $prefixe)) {

                                dump($prefixe);


                                // $explod = explode($indicatifTabValue, $caller);

                                // $findPrefixe = $explod[1];


                                // if (strpos($findPrefixe, $prefixe) === 0) {




                                //     //Trouver le bon OBJET
                                //     $findRef = $this->em->getRepository(IndicatifSda::class)->findOneBy([
                                //         //trouver l'indicatif et prefixe qui correspond au num
                                //         "indicatif" => $indicatifTabValue,
                                //         "prefixe" => $prefixe

                                //     ]);


                                //     $paramCodeIso = $findRef->getCodeIso();

                                //     $paramCallSign = $findRef->getIndicatif();
                                //     $paramPrefixe = $findRef->getPrefixe();
                                //     $paramGeolocalisation = $findRef->getZone();


                                //     $paramsEntity = (new ParamSDA())
                                //         ->setName($voxwide->getCaller())
                                //         ->setCodeISO($paramCodeIso)
                                //         ->setCode("1")
                                //         ->setCallsign($paramCallSign)
                                //         ->setStatus('1')
                                //         ->setPrefix($paramPrefixe)
                                //         ->setFormat(1)
                                //         ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                                //         ->setActivate('0')
                                //         ->setEtat("0")
                                //         ->setGeolocalisation($paramGeolocalisation);



                                //     // persist
                                //     $this->em->persist($paramsEntity);
                                // }
                            } else {

                                dump("test");
                            }
                        }



                        // new SDA


                        //persist


                    }
                }
                try {
                    if (($count % $batchSize) === 0) {
                        $this->em->flush(); // Exécute un INSERT INTO pour chaque produit
                        $this->em->clear(); // Libère la mémoire
                        $checkPhoneNumber = [];
                    }

                    $count++;
                } catch (\Exception $e) {
                    echo $e;
                }

                // Envoi des données par paquet de 20 à la base de données

            }
            // Flush pour envoyer les changements à la base de données
            $this->em->flush();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }



    // Vérication de la longueur du numéro 
    public function checkNumberLength(string $number): bool
    { // Vérifie s'il y a l'indicatif "+262" dans le numéro
        if (strlen($number) !== 9) {
            return true;
        } else return false;
    }
}
