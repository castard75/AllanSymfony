<?php

namespace App\Command;

set_time_limit(0);

use App\Entity\Event;
use App\Entity\ParamAPI;
use App\Entity\Tiers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Process\Process;

use \DateTimeImmutable;
use \DateTimeZone;

use function PHPUnit\Framework\isNull;

#[AsCommand('app:Api:sync', 'Sync from all Api with db')]
class SyncApi extends Command
{
    private $client;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
    }

    /**
     * Check if the folder exist , if exist execute each command of AllCommand.php
     * with different arguments, else insert a new Event.
     *
     * @param string $folderPath  Path to sync folder "dolifact_14_0_3"...
     * @param string $version Get Version from ParamApi class
     * @param integer $api_id Get Id from ParamApi class
     * @param string $apiName Get Name from ParamApi class
     * @param string $apiLabel Get label from ParamApi class
     * @param $em \Doctrine\ORM\EntityManagerInterface
     * @param $io \Symfony\Component\Console\Style\SymfonyStyle
     * 
     * If exist execute AllCommand -> $commands, else insert new event  
     */

    private function folder_exist(string $folderPath, string $version, int $api_id, string $apiName, string $apiLabel, string $apiUrl, string $apiToken, $em, $io, $ovh_header = [])
    {
        if (file_exists($folderPath)) {

            include $folderPath . '/AllCommand.php';

            // Loop on array $commands[] from AllCommand.php
            foreach ($commands as $command) {

                // Execute a 'php bin/console' command in sub-process
                $process = new Process(explode(' ', 'php bin/console ' . $command . ' ' . $api_id . ' ' . $apiName . ' ' . $apiLabel . ' ' . $apiUrl . ' ' . $apiToken . ' ' . json_encode($ovh_header)));
                $process->setTimeout(0);
                $process->start();

                foreach ($process as $data) {
                    $io->info($command . ' ' . $data);
                }

                $process->wait();
            }
        } else {

            // Checks if there is already an "event" element with the corresponding fields 
            // else insert
            $occurence = $em->getRepository(Event::class)
                ->findOneBy(array(
                    "service" => $apiLabel . ' -> ' . $apiName,
                    "paramApi" => $api_id,
                    "status" => '1'
                ));

            if (is_null($occurence)) {

                $event_entity = new Event();
                $event_entity
                    ->setUuid('uuid')
                    ->setMessage("le dossier de syncro " . $apiLabel . "_" . $apiName . " n'existe pas")
                    ->setService($apiLabel . ' -> ' . $apiName)
                    ->setStatus('1')
                    ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                    ->setActivate('0')
                    ->setEtat('0')
                    ->setParamApi($api_id);

                $em->persist($event_entity);
                $em->flush();

                $io->info("Inserting new Event " . $event_entity->getId());
            }
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {


        ini_set('max_execution_time', 0);
        $f = fopen('sync_api', 'w') or die('Cannot create lock file');
        $io = new SymfonyStyle($input, $output);

        if (!flock($f, LOCK_EX | LOCK_NB)) {
            $io->error("Command already running !");
            return Command::FAILURE;
        }

        $em = $this->entityManager;

        $paramApis = $this->entityManager->getRepository(ParamAPI::class)->findAll();

        // For each element of the ParamApi table, stock the data from each column 
        foreach ($paramApis as $paramApi) {

            $api_id = $paramApi->getId();
            $apiName = $paramApi->getName();
            $apiLabel = $paramApi->getLabel();
            $apiUrl = $paramApi->getUrl();
            $version = $paramApi->getVersion();
            $apiToken = $paramApi->getToken();
            $version_ = str_replace('.', '_', $version);
            $secretToken = $paramApi->getSecretToken();
            $endPoint = $paramApi->getEndPoint();
            $userKey = $paramApi->getUserKey();


            $this->client = HttpClient::create()->withOptions([
                'headers' => [
                    'Accept' => 'application/json',
                    'DOLAPIKEY' => $apiToken
                ]
            ]);

            // Treats each label name
            switch ($apiLabel) {

                case "dolifact":

                    $responseParamApi = $this->client->request('GET', $apiUrl . "/status/");
                    print_r($responseParamApi);
                    if ($responseParamApi->getStatusCode() == 200) {

                        $contentParamApi = json_decode($responseParamApi->getContent(), true);

                        // Loop for each dolifact/status from Api
                        foreach ($contentParamApi as $paramApi) {


                            $dolibarVersion = $paramApi['dolibarr_version'];

                            // Compares the version in DB with the Api version
                            if ($dolibarVersion == $version) {

                                try {

                                    $folderPath = __DIR__ . '/' . $apiLabel . '_' . $version_;
                                    $this->folder_exist($folderPath, $version, $api_id, $apiName, $apiLabel, $apiUrl, $apiToken, $em, $io);
                                } catch (\Exception $e) {
                                    $io->error('Failed to sync folder ' . $folderPath . ' : ' . $e->getMessage());
                                }
                            } else {
                                $occurence = $em->getRepository(Event::class)
                                    ->findOneBy(array(
                                        "service" => $apiLabel . ' -> ' . $apiName,
                                        "paramApi" => $api_id,
                                        "status" => '1'
                                    ));

                                // Insert event "la version de correspond pas"
                                if (is_null($occurence)) {

                                    $event_entity = new Event();
                                    $event_entity
                                        ->setUuid('uuid')
                                        ->setMessage("La version de l'api " . $version . " ne correspond pas")
                                        ->setService($apiLabel . ' -> ' . $apiName)
                                        ->setStatus('1')
                                        ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                                        ->setActivate('0')
                                        ->setEtat('0')
                                        ->setParamApi($api_id);

                                    $em->persist($event_entity);
                                    $em->flush();

                                    $io->info("Inserting new Event " . $event_entity->getId());
                                }
                            }
                        }
                    }
                    break;

                case 'Ovh':

                    // Array contains ovh configuration parameters from param_api table
                    $ovh_header = [];
                    array_push($ovh_header, $secretToken);
                    array_push($ovh_header, $endPoint);
                    array_push($ovh_header, $userKey);

                    try {
                        $folderPath = __DIR__ . '/' . $apiLabel;

                        $this->folder_exist($folderPath, $version, $api_id, $apiName, $apiLabel, '', $apiToken, $em, $io, $ovh_header);
                    } catch (\Exception $e) {
                        $io->error('Failed to sync folder ' . $folderPath . ' : ' . $e->getMessage());
                    }

                    $occurence = $em->getRepository(Event::class)
                        ->findOneBy(array(
                            "service" => $apiLabel . ' -> ' . $apiName,
                            "paramApi" => $api_id,
                            "status" => '1'
                        ));

                    // Insert event "Les informations de configuration incorrect"
                    if (is_null($occurence)) {
                        $event_entity = new Event();
                        $event_entity
                            ->setUuid('uuid')
                            ->setMessage("Les informations de configuration de l'api " . $apiName . " sont incorrect.")
                            ->setService($apiLabel . ' -> ' . $apiName)
                            ->setStatus('1')
                            ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                            ->setActivate('0')
                            ->setEtat('0')
                            ->setParamApi($api_id);

                        $em->persist($event_entity);
                        $em->flush();

                        $io->info("Inserting new Event " . $event_entity->getId());
                    }

                    break;
                default:
                    break;
            }
            $em->flush();
        }

        return Command::SUCCESS;
    }
}
