<?php

namespace App\Command\Ovh;

use App\Entity\ParamOvh;
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
use \Ovh\Api;
use \DateTimeImmutable;
use \DateTimeZone;
require __DIR__ . '/../../../vendor/autoload.php';

#[AsCommand('app:paramOvh', 'Sync paramOvh')]
class SyncParamOvh extends Command
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
        
        $f = fopen('sync_paramOvh', 'w') or die('Cannot create lock file');
        $io = new SymfonyStyle($input, $output);
        $em = $this->entityManager;

        
        if (!flock($f, LOCK_EX | LOCK_NB)) {
            $io->error("Command already running !");
            return Command::FAILURE;
        }

        $argumentId = $input->getArgument('id');
        $ovh_header = json_decode($input->getArgument('ovh_header'));
        $ovh_token = $input->getArgument('token');
        
        $applicationKey = $ovh_token;
        $applicationSecret = $ovh_header[0];
        $endpoint = $ovh_header[1];
        $consumerKey = $ovh_header[2];
        
        // Will contain the email addresses
        $tableMail = [];

        // Api credentials can be retrieved from the urls specified in the "Supported endpoints" section below.
        $ovh = new Api($applicationKey,
                        $applicationSecret,
                        $endpoint,
                        $consumerKey);

        $organizationNames = $ovh->get('/email/exchange') ;

        
        foreach ($organizationNames as $organizationName){
            
            // callApi to get exchangesServices
            $exchangeServices = $ovh->get('/email/exchange/'.$organizationName.'/service') ;

            foreach ($exchangeServices as $exchangeService){

                // callApi to get primaryEmailsAddress
                $primaryEmailsAddress = $ovh->get('/email/exchange/'.$organizationName.'/service/'.$exchangeService.'/account');


                foreach($primaryEmailsAddress as $primaryEmailAddress ){
                    array_push($tableMail, $primaryEmailAddress);
                    try{
                        $paramOvh_entity = new ParamOvh();

                        $occurence = $em->getRepository(ParamOvh::class)
                        ->findOneBy(array(
                            "primaryEmailAddress" => $primaryEmailAddress,
                            "exchangeService" => $exchangeService,
                            "organizationName" => $organizationName
                        ));
    
                        if(is_null($occurence)){
                            $io->info("Inserting new paramOvh ");
                            $paramOvh_entity
                                ->setPrimaryEmailAddress($primaryEmailAddress)
                                ->setExchangeService($exchangeService)
                                ->setOrganizationName($organizationName)
                                ->setStatus('0')
                                ->setDuplicate('0')
                                ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                                ->setActivate('0')
                                ->setEtat('0')
                                ->setParamApi($argumentId);
        
                            $em->persist($paramOvh_entity);
        
                        }
                    }catch (\Exception $e) {
                        $io->error('Failed to insert paramOvh : ' . $e->getMessage());
                    }
                
                }
        
            }
        
        } 
        
        $tableParamOvh = [];
        $occurence = $em->getRepository(ParamOvh::class) 
            ->findWithNonNullFields($argumentId);

            foreach ($occurence as $paramOvh) {
                
                array_push($tableParamOvh, $paramOvh->getPrimaryEmailAddress());
                
                if (in_array($paramOvh->getPrimaryEmailAddress(), $tableMail)) {
                    $paramOvh
                        ->setDeletedAt(NULL);
                    $em->persist($paramOvh);
                } else {
                    $paramOvh
                        ->setDeletedAt(new DateTimeImmutable(date('Y-m-d H:i:s')));
                    $em->persist($paramOvh);
                }
            }
    
        
        $em->flush();

        $io->success(sprintf('End'));

        return Command::SUCCESS;
    }




};