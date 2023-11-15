<?php

namespace App\Command;

use App\Entity\TokenFirebase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:syncfirebase',
)]
class SyncFirebase extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName('SyncFirebase')
            ->setDescription('Synchronisation firbase')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = $_ENV['CLE_SERVEUR_FIREBASE'];

        $ListeToken = $this->entityManager->getRepository(TokenFirebase::class)->createQueryBuilder('u')->where('u.deletedat IS NULL')->getQuery()->execute();
        foreach($ListeToken as $val){
            $device_id[] = $val->getToken();
        }
        if(isset($device_id)){
            $MyMessage = "maj ".date("Y-m-d H:i:s");
            $MesInfos['registration_ids'] = $device_id;
            $MesInfos['data']['message'] = $MyMessage;
            $MesInfos['android']['priority'] = "HIGH";
            $MesInfos['webpush']['headers']['Urgency'] = "high";
            $MesInfos['priority'] = 10;
            $MesInfos['collapse_key'] = 'collapseKey';
            $headers = array('Content-Type:application/json', 'Authorization:key='.$api_key);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($MesInfos));
            $result = curl_exec($ch);
            curl_close($ch);
        }

        return Command::SUCCESS;
    }
}