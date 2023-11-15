<?php

namespace App\Command;


use App\Entity\Myconnectors;
use App\Entity\Planning;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:planning',
)]
class PlanningDate extends Command
{
    private $entityManager;
    private $ClientHTTP;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this->setName('planningDateSync')
            ->setDescription('Synchronistaion des date')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $today = new DateTimeImmutable();
        $ListeConnector = $this->entityManager->getRepository(Myconnectors::class)->createQueryBuilder('u')->where('u.url IS NOT NULL')->getQuery()->execute();
        foreach ($ListeConnector as $Val) {
            $OrigineId = $Val->getId();
            $UrlApi = $Val->getUrl();
            $TokenApi = $Val->getLogin();
            
            for ($i = 0; $i < 24; $i++) {
                
                $planning = new Planning();
                
                
                $planning->setDuplanning($today);
                $planning->setOrigineid($OrigineId);
                
               
                $futureDate = $today->modify('+6 days');
                $planning->setAuplanning($futureDate);
                
                
                
          
                $this->entityManager->persist($planning);
                $this->entityManager->flush();
   
                $today = $futureDate->modify('+1 days');
            }
        }
        return Command::SUCCESS;
    }


    }

    

