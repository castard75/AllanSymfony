<?php

namespace App\Command\dolifact_14_0_3;

use App\Entity\Contact;
use App\Entity\Tiers;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Input\InputArgument;


use \DateTimeImmutable;
use \DateTimeZone;

#[AsCommand('app:thirdparties_contact_dolifact_14_0_3', 'Sync dolifact thirdparties and contact with db')]
class SyncThirdparties_contact extends Command
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
        
        $f = fopen('sync_thirdparties', 'w') or die('Cannot create lock file');
        $io = new SymfonyStyle($input, $output);
        
        if (!flock($f, LOCK_EX | LOCK_NB)) {
            $io->error("Command already running !");
            return Command::FAILURE;
        }
        $apiUrl = $input->getArgument('url');
        $apiToken = $input->getArgument('token');

        $this->client = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $apiToken
            ]
        ]);

        // Get thirdparties and contacts from DOL API
        $response = $this->client->request('GET', $apiUrl . "/thirdparties?sortfield=t.rowid&sortorder=ASC&limit=100000");
        $responseContacts = $this->client->request('GET', $apiUrl . "/contacts?sortfield=t.rowid&sortorder=ASC&limit=100000");
        $em = $this->entityManager;

        $io->title('Fetching dolifact : ');

        if ($response->getStatusCode() != 200 || $responseContacts->getStatusCode() != 200) {
            $io->error("Can't communicate with Dolibarr !");
            return Command::FAILURE;
        }

        $content = json_decode($response->getContent(), true);
        $contentContact = json_decode($responseContacts->getContent(), true);


        // -------------------- LOOP ON TIERS ----------------------

        $argumentId = $input->getArgument('id');
        /**
         * Will contain third-party ids from dolifact
         */
        $tierId = [];
        foreach ($content as $thirdparties)
        {
            try {
                // echo json_encode($thirdparties);

                $tiers_entity = new Tiers();

                $occurence = $em->getRepository(Tiers::class)
                    ->findOneBy(array(
                        "originId" => $thirdparties['id'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId                      
                    ));

                if (strlen($thirdparties['zip']) > 10) {
                    $thirdparties['zip'] = substr($thirdparties['zip'], 0, 10);
                }
                if (is_null($occurence)) 
                {
                    echo json_encode($thirdparties['id']);

                    $io->info("Inserting new thirdparties " . $thirdparties['id']);
                    $tiers_entity
                        ->setUuid('uuid')
                        ->setOrigin('dolifact')
                        ->setOriginId($thirdparties['id'])
                        ->setReference($thirdparties['code_client'] != NULL ? $thirdparties['code_client'] : $thirdparties['code_fournisseur'] ?? "default")
                        ->setLabel($thirdparties['name'])
                        ->setAlias($thirdparties['name_alias'])
                        ->setCustomer($thirdparties['client'])
                        ->setSupplier($thirdparties['fournisseur'])
                        ->setSiren($thirdparties['idprof1'])
                        ->setSiret($thirdparties['idprof2'])
                        ->setMail($thirdparties['email'])
                        ->setPhone($thirdparties['phone'])
                        ->setAddress($thirdparties['address'])
                        ->setPostal($thirdparties['zip'])
                        ->setCity($thirdparties['town'])
                        ->setCountry($thirdparties['country_code'])
                        ->setStatus($thirdparties['status'] ? $thirdparties['status'] : '0')
                        ->setDuplicate('0')
                        ->setActivate('0')
                        ->setEtat('0')
                        ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $thirdparties['date_creation'])))
                        ->setParamApi($argumentId);


                    $em->persist($tiers_entity);
                }

        // -------------------- UPDATE TIERS ----------------------

                // echo json_encode($thirdparties);
                if ($occurence) {
                    // ternaire si updatedAt NULL prend 0
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    // echo json_encode($updatedTimestamp);

                    //  TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 15400120) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;
                    // echo json_encode($updatedTimestamp);
                    if ($thirdparties['date_modification'] > $updatedTimestamp) 
                    {
                        $io->info("Updating thirdparties " . $thirdparties['id']);
                        $occurence
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($thirdparties['id'])
                            ->setReference($thirdparties['code_client'] != NULL ? $thirdparties['code_client'] : $thirdparties['code_fournisseur'] ?? "default")
                            ->setLabel($thirdparties['name'])
                            ->setAlias($thirdparties['name_alias'])
                            ->setCustomer($thirdparties['client'])
                            ->setSupplier($thirdparties['fournisseur'])
                            ->setSiren($thirdparties['idprof1'])
                            ->setSiret($thirdparties['idprof2'])
                            ->setMail($thirdparties['email'])
                            ->setPhone($thirdparties['phone'])
                            ->setAddress($thirdparties['address'])
                            ->setPostal($thirdparties['zip'])
                            ->setCity($thirdparties['town'])
                            ->setCountry($thirdparties['country_code'])
                            ->setStatus($thirdparties['status'] ?? '0')
                            ->setDuplicate('0')
                            // TEST
                            // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                            ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $thirdparties['date_modification'])));

                        $em->persist($occurence);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated thirdparties : ' . $e->getMessage());
            }

            // Stacks the third-party ids from dolyfact at the end of $tierId[]
            array_push($tierId, $thirdparties['id']);
        }

        // -------------------- CHECK TIERS ORIGIN_ID TO ID ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $tiersOriginId = [];
        $occurence = $em->getRepository(Tiers::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId
            ));

        foreach ($occurence as $tiers) {
            array_push($tiersOriginId, $tiers->getOriginId());
        }

        foreach ($tiersOriginId as $id) {
            $occurence = $em->getRepository(Tiers::class)
                ->findOneBy(array(
                    "originId" => $id,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId
                ));
            if (in_array($id, $tierId)) {
                // update deleteAt = NULL
                $occurence
                    ->setDeletedAt(NULL);
                $em->persist($occurence);
            } else {
                $occurence
                // update deleteAt = Datetime
                    ->setDeletedAt(new DateTimeImmutable(date('Y-m-d H:i:s')));
                $em->persist($occurence);
            }
        }

        $em->flush();

        // -------------------- LOOP ON CONTACT ----------------------

        /**
         * Will contain contacts ids from dolifact
         */
        $contactId = [];
        foreach ($contentContact as $contact) {
            try {

                // echo json_encode($contact);
                $contact_entity = new Contact();

                // Checks if the contact already exists in the database
                $occurence = $em->getRepository(Contact::class)
                    ->findOneBy(array(
                        "originId" => $contact['id'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId 
                    ));

                $thirdparties = $em->getRepository(Tiers::class)
                    ->findOneBy(array(
                        "originId" => $contact['socid'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId 

                    ));



                if (is_null($occurence)) {
                    if ($contact['socid'] > 0 && !is_null($thirdparties) && !empty($thirdparties) && !empty($contact)) {
                        $io->info("Inserting new contact " . $contact['id']);
                        $contact_entity
                            ->setFkTiers($thirdparties)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($contact['id'])
                            ->setReference($contact['ref'])
                            ->setFirstName($contact['firstname'])
                            ->setLastName($contact['lastname'])
                            ->setPhone($contact['phone_pro'])
                            ->setMail($contact['email'])
                            ->setFunction('0')
                            ->setStatus($contact['status'] ? $contact['status'] : '0')
                            ->setActivate('0')
                            ->setEtat('0')    
                            ->setDuplicate('0')
                            ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $contact['date_creation'])))
                            ->setParamApi($argumentId);

                        $em->persist($contact_entity);
                    }
                }

        // -------------------- UPDATE CONTACT----------------------

                else {
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    // TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 120812) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;
                    // echo json_encode($contact);
                    if ($contact['date_modification'] > $updatedTimestamp) {
                        $io->info("Updating contact " . $contact['id']);
                        $occurence
                            ->setFkTiers($thirdparties)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($contact['id'])
                            ->setReference($contact['ref'])
                            ->setFirstName($contact['firstname'])
                            ->setLastName($contact['lastname'])
                            ->setPhone($contact['phone_pro'])
                            ->setMail($contact['email'])
                            ->setFunction('0')
                            ->setStatus($contact['status'] ? $contact['status'] : '0')
                            ->setDuplicate('0')
                            //  TEST
                            // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                            ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $contact['date_modification'])));

                        $em->persist($occurence);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated contact : ' . $e->getMessage());
            }
            array_push($contactId, $contact['id']);
        }


        // -------------------- CHECK CONTACT ORIGIN_ID TO ID ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $contactOriginId = [];
        $occurence = $em->getRepository(Contact::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId 
            ));

        foreach ($occurence as $contact) {
            array_push($contactOriginId, $contact->getOriginId());
        }

        foreach ($contactOriginId as $id) {
            $occurence = $em->getRepository(Contact::class)
                ->findOneBy(array(
                    "originId" => $id,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId 

                ));
            if (in_array($id, $contactId)) {
                // update deleteAt = NULL
                $occurence
                    ->setDeletedAt(NULL);
                $em->persist($occurence);
            } else {
                $occurence
                    // update deleteAt = Datetime
                    ->setDeletedAt(new DateTimeImmutable(date('Y-m-d H:i:s')));
                $em->persist($occurence);
            }
        }

        $em->flush();


        $io->success(sprintf('End'));

        return Command::SUCCESS;
    }
}
