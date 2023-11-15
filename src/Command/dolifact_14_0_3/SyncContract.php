<?php

namespace App\Command\dolifact_14_0_3;

use App\Entity\Contract;
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
use Symfony\Component\Console\Input\InputArgument;


use \DateTimeImmutable;
use \DateTimeZone;

#[AsCommand('app:contract_dolifact_14_0_3', 'Sync dolifact contract with db')]
class SyncContract extends Command
{
    /**
     * Client HTTP
     *
     * @var object
     */
    private $client;
    /**
     * Manages database objects
     *
     * @var object
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        // Initialise the HTTP client with the appropriate headers
  
    }

    protected function configure()
    {
        $this
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
            ->addArgument('id', InputArgument::REQUIRED, 'id')
            ->addArgument('name',  InputArgument::REQUIRED, 'name')
            ->addArgument('label',InputArgument::REQUIRED, 'label')
            ->addArgument('url',InputArgument::REQUIRED, 'url')
            ->addArgument('token',InputArgument::REQUIRED, 'token')
            ->addArgument('ovh_header',InputArgument::REQUIRED, 'ovh_header');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $f = fopen('sync_contract', 'w') or die('Cannot create lock file');
        $io = new SymfonyStyle($input, $output);

        if (!flock($f, LOCK_EX | LOCK_NB)) {
            $io->error("Command already running !");
            return Command::FAILURE;
        }
        
        $argumentId = $input->getArgument('id');
        $apiUrl = $input->getArgument('url');
        $apiToken = $input->getArgument('token');

        $this->client = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $apiToken
            ]
        ]);

        $responseContract = $this->client->request('GET', $apiUrl . "/contracts?sortfield=t.rowid&sortorder=ASC&limit=100000");
        $em = $this->entityManager;

        $io->title('Fetching dolifact : ');

        if ($responseContract->getStatusCode() != 200) {
            $io->error("Can't communicate with Dolibarr !");
            return Command::FAILURE;
        }

        $contentContract = json_decode($responseContract->getContent(), true);

        // -------------------- LOOP ON CONTRACT ----------------------


        /**
         * Will contain category ids from dolifact
         */
        $contractId = [];
        foreach ($contentContract as $contract) {
            try {
                $contract_entity = new Contract();

                $occurence = $em->getRepository(Contract::class)
                    ->findOneBy(array(
                        "originId" => $contract['id'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId
                    ));

                // Object of the Third Party class that refers to a record that matches the criteria (originId => $contract['socid']...)
                $tiers = $em->getRepository(Tiers::class)
                    ->findOneBy(array(
                        "originId" => $contract['socid'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId 

                    ));

                if (is_null($occurence)) {
                    $io->info("Inserting new contract " . $contract['id']);

                    $contract_entity
                        ->setFkTiers($tiers)
                        ->setUuid('uuid')
                        ->setOrigin('dolifact')
                        ->setOriginId($contract['id'])
                        ->setReference($contract['ref'])
                        ->setLabel($contract['ref'])
                        ->setStartAt(DateTimeImmutable::createFromFormat('U', $contract['date_contrat']))
                        // ->setEndAt('')
                        ->setStatus('0')
                        ->setActivate('0')
                        ->setEtat('0')
                        ->setType('0')
                        ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $contract['date_creation'])))
                        ->setParamApi($argumentId);

                    $em->persist($contract_entity);
                }


                // -------------------- UPDATE CONTRACT ----------------------


                if ($occurence) {
                    // ternaire si updatedAt NULL prend 0
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    //  TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 15400120) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;
                    if ($contract['date_modification'] > $updatedTimestamp) {
                        $io->info("Updating contract " . $contract['id']);
                        $occurence
                            ->setFkTiers($tiers)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setReference($contract['ref'])
                            ->setLabel($contract['ref'])
                            ->setStartAt(DateTimeImmutable::createFromFormat('U', $contract['date_contrat']))
                            ->setStatus('0')
                            // ->setEndAt('')
                            // TEST
                            // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                            ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $contract['date_modification'])));

                        $em->persist($occurence);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated contract : ' . $e->getMessage());
            }
            // Stacks the contract ids from dolyfact at the end of $contractId[]
            array_push($contractId, $contract['id']);
        }


        // -------------------- CHECK CONTRACT ORIGIN_ID TO ID ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $contractOriginId = [];
        $occurence = $em->getRepository(Contract::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId 

            ));

        foreach ($occurence as $contract) {
            array_push($contractOriginId, $contract->getOriginId());
        }

        foreach ($contractOriginId as $OriginId) {
            $occurence = $em->getRepository(Contract::class)
                ->findOneBy(array(
                    "originId" => $OriginId,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId 

                ));
            if (in_array($OriginId, $contractId)) {
                $occurence
                    ->setDeletedAt(NULL);
                $em->persist($occurence);
            } else {
                $occurence
                    ->setDeletedAt(new DateTimeImmutable(date('Y-m-d H:i:s')));
                $em->persist($occurence);
            }
        }

        $em->flush();

        $io->success(sprintf('End'));

        return Command::SUCCESS;
    }
}
