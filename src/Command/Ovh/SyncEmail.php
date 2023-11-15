<?php

namespace App\Command\Ovh;

use App\Entity\ParamOvh;
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

#[AsCommand('app:email_ovh', 'Sync email from ovh')]
class SyncEmail extends Command
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
            ->addArgument('label', InputArgument::REQUIRED, 'label')
            ->addArgument('url', InputArgument::REQUIRED, 'url')
            ->addArgument('token', InputArgument::REQUIRED, 'token')
            ->addArgument('ovh_header', InputArgument::REQUIRED, 'ovh_header');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $f = fopen('sync_emailOvh', 'w') or die('Cannot create lock file');
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

        // Api credentials can be retrieved from the urls specified in the "Supported endpoints" section below.
        $ovh = new Api(
            $applicationKey,
            $applicationSecret,
            $endpoint,
            $consumerKey
        );



        $specific_datas_for_emails = $ovh->get('/email/exchange/{organizationName}/service/{exchangeService}/account/{primaryEmailAddress}');
        $paramOvh_data = $em->getRepository(ParamOvh::class);
        // findby paramApi == argument Id
        foreach ($paramOvh_data as $data) {

            $primaryEmailAdress = $data->getPrimaryEmailAddress();
            $exchangeService = $data->getExchangeService();
            $organizationName = $data->getOrganizationName();

            $specific_datas_for_emails = $ovh->get('/email/exchange/' . $organizationName . '/service/' . $exchangeService . '/account/' . $primaryEmailAdress . '');
            dump($specific_datas_for_emails);
            // foreach($specific_datas_for_emails as $specific_datas_for_email){
            //     // occurence
            //     // if is_null occurence
            //     // email_entity
            //     // insert
            //     // ->
            // ->setParamApi($argumentId);
            // }
        }



        $em->flush();

        $io->success(sprintf('End'));

        return Command::SUCCESS;
    }
};
