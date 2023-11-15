<?php

namespace App\Command\voxnode;

use DateTimeImmutable;



// use App\Entity\Voxwide;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Cdr;
use App\Entity\Sda;
use App\Entity\ParamSDA;
use App\Entity\IndicatifSda;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use League\Csv\Reader;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand('app:voxwide', 'Sync email from ovh')]
class VoxwideCommand extends Command
{

    // protected static $defaultName = 'app:voxwide';

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
        $dir = __DIR__ . '/../../../public/uploads/imports/voxnode';
        $dir2 = __DIR__ . '/../../../public/uploads/processed/';


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
                    // Récupérer la date du jour
                    $filename_date = new \DateTime();

                    // Récupère l'extension du fichier
                    $extension = pathinfo($file, PATHINFO_EXTENSION);

                    // Récupère le nom de fichier sans extension " ex : titre"
                    $baseName = basename($file, '.' . $extension);

                    // Déplacer le fichier CSV dans le répertoire var/imports/processed avec un nom de fichier composé du nom de fichier d'origine, de la date du jour et de l'extension
                    rename($dir .  '/' . $file, $dir2 . $baseName .  '-' . $filename_date->format('Y_m_d_H_i_s') . '.' . $extension);


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


                $dateImmutable = DateTimeImmutable::createFromFormat($format, $col[4]);

                $existingCDR = $this->em->getRepository(CDR::class)->findOneBy([
                    'sipTrunk' => $col[1],
                    'caller' => $col[2],
                    'called' => $col[3],
                    'dateAt' => $dateImmutable,
                ]);
                // Créer un nouvel objet Voxwide
                $Sda_entity = new Sda();
                if (!$existingCDR) {
                $voxwide = (new CDR())
                    ->setSiptrunk($col[1])
                    ->setCaller($col[2])
                    ->setCalled($col[3])
                    ->setDateAt($dateImmutable)
                    ->setOrigin("Voxnode")
                    ->setPrice($col[6])
                    ->setAnomaly(false)
                    ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                    ->setOriginId("0")
                    ->setDevise("Eur")
                    ->setstatus("1")
                    ->setEtat("0")
                    ->setActivate("0");


                //Condition pour vérifier si le numéro est correcte dans ma boucle 
                if ($this->checkNumberLength($voxwide->getCalled())) {
                    $voxwide->setAnomaly(true)
                        ->setComment("Numéro incomplet");
                }
                // Vérifie s'il y a l'indicatif "+262" dans le numéro
                if (substr_count($col[3], "+262692")) {

                    $voxwide->setType(1);
                } elseif (substr_count($col[3], "+262693")) {

                    $voxwide->setType(1);
                } elseif (substr_count($col[3], "+336")) {

                    $voxwide->setType(1);
                } elseif (substr_count($col[3], "+262639")) {

                    $voxwide->setType(1);
                } else {

                    $voxwide->setType(0);
                }


                // SetternewparamsSda


                // Enregistrer le produit dans la base de données
                $this->em->persist($voxwide);




               
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
            } else {

                var_dump("Fichier à jour");
            }
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
        if (substr_count($number, "+262")) {
            // Si l'indicatif "+262" est présent, divise le numéro en deux parties :
            // la partie avant l'indicatif et la partie après l'indicatif

            $explod = explode("+262", $number);
        } elseif (substr_count($number, "+33")) {
            $explod = explode("+33", $number);
        } else {
            return true;
        }
        //strlen contient le reste du numéro après l'indicatif, on retourne les numéro qui ne sont pas égale à 9
        return !(9 == strlen($explod[1]));
    }


    public function checkDevise(string $prix): string
    {
        $explodPrice = explode(" ", $prix);
        $devise = $explodPrice[1];

        return $devise;
    }
}
