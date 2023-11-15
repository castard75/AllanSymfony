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

#[AsCommand('app:DataFromEmailTest', 'Show data from email test')]
class DataFromEmailTest extends Command
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
        $applicationKey = '0addbcfd45a12439';
        $applicationSecret = '2c0f9c79b8ea4367e06d4ccc41f2b6ed';
        $consumerKey = '1519a3fa93a5a06328d5528ee5f7e6e4';
        $endpoint = 'ovh-eu';

        // Api credentials can be retrieved from the urls specified in the "Supported endpoints" section below.
        $ovh = new Api(
            $applicationKey,
            $applicationSecret,
            $endpoint,
            $consumerKey
        );
        
        // $data = '';
        // $file =  __DIR__ .'/../log.txt';
        // $handle = fopen($file, 'w'); // 
        
        $organizationNames = $ovh->get('/email/exchange');

        foreach ($organizationNames as $organizationName) {

            $exchangeServices = $ovh->get('/email/exchange/' . $organizationName . '/service');

            foreach ($exchangeServices as $exchangeService) {

                $primaryEmailsAddress = $ovh->get('/email/exchange/' . $organizationName . '/service/' . $exchangeService . '/account');

                foreach ($primaryEmailsAddress as $primaryEmailAddress) {

                    $specific_datas_for_emails = $ovh->get('/email/exchange/'.$organizationName.'/service/'.$exchangeService.'/account/'.$primaryEmailAddress.'');
                    dump($specific_datas_for_emails);

        // $data .= json_encode($specific_datas_for_emails).'\r\n';
                }
            }
        }
        // fwrite($handle, $data);
        // fclose($handle);
    }
}


// $em->flush();

// $io->success(sprintf('End'));

return Command::SUCCESS;
