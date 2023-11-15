<?php

namespace App\Command;

use App\Entity\Products;
use App\Entity\Customers;
use App\Entity\Customerscontact;
use App\Entity\Myconnectors;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

#[AsCommand(
    name: 'app:syncproducts',
)]
class SyncProducts extends Command
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
        $this->setName('SyncProducts')
            ->setDescription('Synchronistaion des produits')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $ListeConnector = $this->entityManager->getRepository(Myconnectors::class)->createQueryBuilder('u')->where('u.url IS NOT NULL')->getQuery()->execute();
        foreach ($ListeConnector as $Val) {
            //Récupere les infos Doli
            $OrigineId = $Val->getId();
            $UrlApi = $Val->getUrl();
            $TokenApi = $Val->getLogin();

            $this->recupererProduits($OrigineId, $UrlApi, $TokenApi);
        }

        return Command::SUCCESS;
    }

    private function recupererProduits($OrigineId, $UrlApi, $TokenApi)
    {
        $em = $this->entityManager;

        $this->ClientHTTP = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $TokenApi
            ]
        ]);

        $RequeteApi = $this->ClientHTTP->request("GET", $UrlApi . "/products?sortfield=t.rowid&sortorder=ASC&limit=100000");
        if ($RequeteApi->getStatusCode() == 200) {
            $content = json_decode($RequeteApi->getContent(), true);

            foreach ($content as $resultat) {


                $Id = trim($resultat['id']);


                $Reference = NULL;
                if (trim($resultat['ref']) != "") {
                    $Reference = trim($resultat['ref']);
                }
                $Label = NULL;
                if (trim($resultat['label'] != "")) {

                    $Label = trim($resultat['label']);
                }
                $Description = NULL;
                if (trim($resultat['description'] != "")) {

                    $Description = trim($resultat['description']);
                }

                $TYPE = NULL;
                if (trim($resultat["type"] != "")) {

                    $TYPE =  trim($resultat['type']);
                }
                $STATUS = NULL;
                if (trim($resultat["status"] != "")) {

                    $STATUS =  trim($resultat['status']);
                }


                dump($resultat);


                $occurence = $em->getRepository(Products::class)
                    ->findOneBy(array(
                        "id" => $Id,

                    ));

                if (is_null($occurence)) {
                    $tp_entity = new Products();
                    $tp_entity
                        ->setName($Label)
                        ->setType($TYPE)
                        ->setTosell($STATUS)
                        ->setReference($Reference);
                    $em->persist($tp_entity);
                } else {
                    $occurence
                        ->setName($Label)
                        ->setType($TYPE)
                        ->setTosell($STATUS)
                        ->setReference($Reference);
                    $em->persist($occurence);
                }
                $em->flush();
            }
        }
    }
}
