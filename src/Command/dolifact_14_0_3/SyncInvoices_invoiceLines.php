<?php

namespace App\Command\dolifact_14_0_3;

use App\Entity\Contract;
use App\Entity\Invoice;
use App\Entity\Tiers;
use App\Entity\InvoiceLines;
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

#[AsCommand('app:invoices_invoicelines_dolifact_14_0_3', 'Sync dolifact invoices_invoiceLines status with db')]
class SyncInvoices_invoiceLines extends Command
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
        $f = fopen('sync_invoices', 'w') or die ('Cannot create lock file');
        $io = new SymfonyStyle($input, $output);

        if (!flock($f, LOCK_EX | LOCK_NB))
        {
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

        $responseInvoice = $this->client->request('GET', $apiUrl . "/invoices?sortfield=t.rowid&sortorder=ASC&limit=100000");
        // $responseInvoiceLines = $this->client->request('GET', $_ENV['DOL_API_URL'] . "/invoices/" . $invoice['id'] . "/lines/");
        $em = $this->entityManager;

        $io->title('Fetching dolifact : ');

        if ($responseInvoice->getStatusCode() != 200 /*|| $responseInvoice_lines->getStatusCode() != 200*/) {
            $io->error("Can't communicate with Dolibarr !");
            return Command::FAILURE;
        }

        $contentInvoice = json_decode($responseInvoice->getContent(), true);
        // $contentInvoiceLines = json_decode($responseInvoiceLines->getContent(), true);


        // -------------------- LOOP ON INVOICE ----------------------

        $argumentId = $input->getArgument('id');
        /**
         * Will contain invoice ids from dolifact
         */
        $InvoiceId = [];
        foreach ($contentInvoice as $bill)
        {
            try {
                // echo json_encode((new \DateTimeImmutable(date('Y-m-d H:i:s', $bill['date'] ?? time()))));

                $invoice_entity = new Invoice();

                $occurence = $em->getRepository(Invoice::class)
                    ->findOneBy(array(
                        "originId" => $bill['id'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId
                    ));

                $tiers = $em->getRepository(Tiers::class)
                ->findOneBy(array(
                       "originId" => $bill['socid'],
                       "origin" => 'dolifact',
                       "paramApi" => $argumentId 

                    ));

                if (is_null($occurence)) 
                {
                    // echo json_encode($bill['date_start']);

                    $io->info("Inserting new invoice " . $bill['id']);
                    $invoice_entity
                        ->setFkTiers($tiers)
                        ->setUuid('uuid')
                        ->setOrigin('dolifact')
                        ->setOriginId($bill['id'])
                        ->setType($bill['type'])
                        ->setSocId($bill['socid'])
                        ->setModeReglement($bill['mode_reglement_code'] ?? '0')
                        ->setConditionReglement($bill['cond_reglement_code'] ?? '0')
                        ->setInvoiceRef($bill['ref'] != NULL ? $bill['ref'] : $bill['ref'] ?? "default")
                        // convert timestamp -> datetime
                        ->setInvoiceDate(new DateTimeImmutable(date('Y-m-d H:i:s', $bill['date'] ?? time())))
                        ->setPaymentDeadline(new DateTimeImmutable(date('Y-m-d H:i:s', $bill['date_lim_reglement'] ?? time())))
                        ->setStatus($bill['status'] ? $bill['status'] : '0')
                        ->setActivate('0')
                        ->setEtat('0')
                        ->setPdfPath($bill['last_main_doc'] ?? '')
                        ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $bill['date_creation'])))
                        ->setParamApi($argumentId);

                    $em->persist($invoice_entity);
                }

        // -------------------- UPDATE INVOICE ----------------------

                // echo json_encode($thirdparties);
                if ($occurence) {
                    // ternaire si updatedAt NULL prend 0
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    // echo json_encode($updatedTimestamp);

                    //  TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 15400120) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;
                    // echo json_encode($bill['mode_reglement_code']);
                    if ($bill['date_modification'] > $updatedTimestamp) 
                    {
                        $io->info("Updating invoice " . $bill['id']);
                        $occurence
                            ->setFkTiers($tiers)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($bill['id'])
                            ->setType($bill['type'])
                            ->setSocId($bill['socid'])
                            ->setModeReglement($bill['mode_reglement_code'] ?? '0')
                            ->setConditionReglement($bill['cond_reglement_code'] ?? '0')
                            ->setInvoiceRef($bill['ref'] != NULL ? $bill['ref'] : $bill['ref'] ?? "default")
                            // date_start pas sur 
                            ->setInvoiceDate(new DateTimeImmutable(date('Y-m-d H:i:s', $bill['date'] ?? time())))
                            ->setPaymentDeadline(new DateTimeImmutable(date('Y-m-d H:i:s', $bill['date_lim_reglement'] ?? time())))
                            ->setStatus($bill['status'] ? $bill['status'] : '0')
                            ->setActivate('0')
                            ->setEtat('0')
                            ->setPdfPath($bill['last_main_doc'] ?? '')
                            // TEST
                            // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                            ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $bill['date_modification'])));
                            
                        $em->persist($occurence);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated invoice : ' . $e->getMessage());
            }

            // Stacks the Invoice ids from dolyfact in $tierId[] array
            array_push($InvoiceId, $bill['id']);
        }

        // -------------------- CHECK INVOICE ORIGIN_ID TO ID (LOCAL) ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $InvoiceOriginId = [];
        $occurence = $em->getRepository(Invoice::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId 

            ));

        foreach ($occurence as $invoice) {
            array_push($InvoiceOriginId, $invoice->getOriginId());
        }

        foreach ($InvoiceOriginId as $id) {
            $occurence = $em->getRepository(Invoice::class)
                ->findOneBy(array(
                    "originId" => $id,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId 

                ));
            if (in_array($id, $InvoiceId)) {
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
    

//         // -------------------- LOOP ON INVOICE_LINES ----------------------

        /**
         * Will contain invoiceLines ids from dolifact
         */
        $invoiceLinesIdArray = [];
        foreach ($contentInvoice as $bill) {

            
            $responseInvoiceLines = $this->client->request('GET', $apiUrl . "/invoices/" . $bill['id'] . "/lines/");
            
            if($responseInvoiceLines->getStatusCode() == 200){
                $contentInvoiceLines = json_decode($responseInvoiceLines->getContent(), true);
            }
            foreach ($contentInvoiceLines as $invoiceLines){
                $invoiceLinesId =  $invoiceLines['id'] ?? 0;
                // echo json_encode($invoiceLines);

            if($invoiceLines > 0){
            try {
                // echo json_encode($contentInvoiceLines);
                $invoiceLines_entity = new InvoiceLines();

                // Checks if the invoiceLines already exists in the database
                $occurence = $em->getRepository(InvoiceLines::class)
                    ->findOneBy(array(
                        "originId" => $invoiceLinesId,
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId
                    ));
                
                $invoice = $em->getRepository(Invoice::class)
                   ->findOneBy(array(
                       "originId" => $bill['id'],
                       "origin" => 'dolifact',
                       "paramApi" => $argumentId 

                    ));

                if (is_null($occurence)) {
                    
                        $io->info("Inserting new invoiceLines " .$invoiceLinesId);
                        $invoiceLines_entity
                            ->setFkInvoice($invoice)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($invoiceLinesId)
                            ->setReference($invoiceLines['ref'])
                            ->setDescription($invoiceLines['desc'])
                            ->setLabel($invoiceLines['label'])
                            ->setTVA($invoiceLines['tva_tx'])
                            ->setPUHT($invoiceLines['subprice'])
                            ->setQuantity($invoiceLines['qty'])
                            ->setDiscountPercent($invoiceLines['remise_percent'])
                            ->setTotalHT($invoiceLines['total_ht'])
                            ->setTotalTVA($invoiceLines['total_tva'])
                            ->setTotalTTC($invoiceLines['total_ttc'])
                            ->setStatus($invoiceLines['status'] ? $invoiceLines['status'] : '0')
                            ->setActivate('0')
                            ->setEtat('0')    
                            ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $invoiceLines['date_creation'])))
                            ->setParamApi($argumentId);
                            
                        $em->persist($invoiceLines_entity);
                    
                }

        // -------------------- UPDATE INVOICE_LINES----------------------

                else {
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    // TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 120812) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;
                    // echo json_encode($contact);
                    if ($invoiceLines['date_modification'] > $updatedTimestamp) {
                        $io->info("Updating invoiceLines " . $invoiceLinesId);
                        $occurence
                        ->setFkInvoice($invoice)
                        ->setUuid('uuid')
                        ->setOrigin('dolifact')
                        ->setOriginId($invoiceLinesId)
                        ->setReference($invoiceLines['ref'])
                        ->setDescription($invoiceLines['desc'])
                        ->setLabel($invoiceLines['label'])
                        ->setTVA($invoiceLines['tva_tx'])
                        ->setPUHT($invoiceLines['subprice'])
                        ->setQuantity($invoiceLines['qty'])
                        ->setDiscountPercent($invoiceLines['remise_percent'])
                        ->setTotalHT($invoiceLines['total_ht'])
                        ->setTotalTVA($invoiceLines['total_tva'])
                        ->setTotalTTC($invoiceLines['total_ttc'])
                        ->setStatus($invoiceLines['status'] ? $invoiceLines['status'] : '0')
                        ->setActivate('0')
                        ->setEtat('0')    
                        //  TEST
                        // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                        ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $invoiceLines['date_modification'])));

                        $em->persist($occurence);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated InvoiceLines : ' . $e->getMessage());
            }
            // echo json_encode($invoiceLines['id']);

            array_push($invoiceLinesIdArray, $invoiceLines['id']);
        }
    }
    }


        // // -------------------- CHECK INVOICE_LINES ORIGIN_ID TO ID ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $invoiceLinesOriginId = [];
        $occurence = $em->getRepository(InvoiceLines::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId 

            ));

        foreach ($occurence as $invoiceLines) {
            array_push($invoiceLinesOriginId, $invoiceLines->getOriginId());
        }

        foreach ($invoiceLinesOriginId as $originId) {
            $occurence = $em->getRepository(InvoiceLines::class)
                ->findOneBy(array(
                    "originId" => $originId,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId 

                ));

            // Si correspondance entre l'originId et l'id  alors ->
            if (in_array($originId, $invoiceLinesIdArray)) {
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
