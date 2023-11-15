<?php

namespace App\Command\dolifact_14_0_3;

use App\Entity\Category;
use App\Entity\Article;
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

#[AsCommand('app:category_article_dolifact_14_0_3', 'Sync dolifact category and article with db')]
class SyncCategory_article extends Command
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
        $f = fopen('sync_category_article', 'w') or die('Cannot create lock file');
        $io = new SymfonyStyle($input, $output);

        if (!flock($f, LOCK_EX | LOCK_NB)) {
            $io->error("Command already running !");
            return Command::FAILURE;
        }
        // Get category and article from DOL API
        $apiUrl = $input->getArgument('url');
        $apiToken = $input->getArgument('token');

        $this->client = HttpClient::create()->withOptions([
            'headers' => [
                'Accept' => 'application/json',
                'DOLAPIKEY' => $apiToken
            ]
        ]);

        $responseCategory = $this->client->request('GET', $apiUrl . "/categories?sortfield=t.rowid&sortorder=ASC&limit=100000");
        $responseArticle = $this->client->request('GET', $apiUrl . "/products?sortfield=t.rowid&sortorder=ASC&limit=100000");
        $em = $this->entityManager;

        $io->title('Fetching dolifact : ');

        if ($responseCategory->getStatusCode() != 200 || $responseArticle->getStatusCode() != 200) {
            $io->error("Can't communicate with Dolibarr !");
            return Command::FAILURE;
        }

        $contentCategory = json_decode($responseCategory->getContent(), true);
        $contentArticle = json_decode($responseArticle->getContent(), true);

        // -------------------- LOOP ON CATEGORY ----------------------

        $argumentId = $input->getArgument('id');

        /**
         * Will contain category ids from dolifact
         */
        $categoryId = [];
        foreach ($contentCategory as $category) {
            try {
                $article_entity = new Article();

                // echo json_encode($category);

                $category_entity = new Category();

                $occurence = $em->getRepository(Category::class)
                    ->findOneBy(array(
                        "originId" => $category['id'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId 

                    ));

                if (is_null($occurence)) {
                    $io->info("Inserting new category " . $category['id']);
                    $category_entity
                        ->setUuid('uuid')
                        ->setOrigin('dolifact')
                        ->setOriginId($category['id'])
                        ->setRelation($category['fk_parent'] ?? "0")
                        ->setLabel($category['label'])
                        ->setStatus('1')
                        ->setActivate('0')
                        ->setEtat('0')
                        ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $category['date_creation'])))
                        ->setParamApi($argumentId);

                    $em->persist($category_entity);
                }

                // -------------------- UPDATE CATEGORY ----------------------

                // echo json_encode($category);
                if ($occurence) {
                    // ternaire si updatedAt NULL prend 0
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    //  TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 15400120) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;
                    // echo json_encode($updatedTimestamp);
                    if ($category['date_modification'] > $updatedTimestamp) {
                        $io->info("Updating category " . $category['id']);
                        $occurence
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($category['id'])
                            ->setRelation($category['fk_parent'] ?? "0")
                            ->setLabel($category['label'])
                            ->setStatus('1')
                            // TEST
                            // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                            ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $category['date_modification'])));

                        $em->persist($occurence);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated category : ' . $e->getMessage());
            }
            // Stacks the third-party ids from dolyfact at the end of $tierId[]
            array_push($categoryId, $category['id']);
        }

        // -------------------- CHECK CATEGORY ORIGIN_ID TO ID ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $categoryOriginId = [];
        $occurence = $em->getRepository(Category::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId 

            ));

        foreach ($occurence as $categ) {
            array_push($categoryOriginId, $categ->getOriginId());
        }

        foreach ($categoryOriginId as $id) {
            $occurence = $em->getRepository(Category::class)
                ->findOneBy(array(
                    "originId" => $id,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId 

                ));
            if (in_array($id, $categoryId)) {
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



        // -------------------- LOOP ON ARTICLE----------------------

        /**
         * Will contain article ids from dolifact
         */
        $articleId = [];
        foreach ($contentArticle as $article) {
            $responseArticlePurchase = $this->client->request('GET', $apiUrl . "/products/" . $article['id'] . "/purchase_prices/");
            $responseArticleCategory = $this->client->request('GET', $apiUrl . "/products/" . $article['id'] . "/categories/");

            // echo $responseArticlePurchase->getStatusCode();

            $articlePurchasePrice = '0';
            $articlePurchaseTVA = '0';
            if ($responseArticlePurchase->getStatusCode() == 200) {
                $contentArticlePurchase = json_decode($responseArticlePurchase->getContent(), true);
                $articlePurchasePrice = $contentArticlePurchase['fourn_price'] ?? '0';
                $articlePurchaseTVA = $contentArticlePurchase['fourn_tva_tx'] ?? '0';
            }

            $articleCategorieId = 0;
            if ($responseArticleCategory->getStatusCode() == 200) {
                $contentArticleCategory = json_decode($responseArticleCategory->getContent(), true);
                $articleCategorieId = $contentArticleCategory['id'] ?? 0;
            }
            try {

                // Checks if the article already exists in the database
                $occurenceArticle = $em->getRepository(Article::class)
                    ->findOneBy(array(
                        "originId" => $article['id'],
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId
                    ));

                $category = $em->getRepository(Category::class)
                    ->findOneBy(array(
                        "originId" => $articleCategorieId,
                        "origin" => 'dolifact',
                        "paramApi" => $argumentId 

                    ));


                if (is_null($occurenceArticle)) {

                    if (!empty($article)) {
                        $article_entity = new Article();
                        $io->info("Inserting new article " . $article['id']);
                        $article_entity
                            ->setFkCategory($category)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($article['id'])
                            ->setReference($article['ref'])
                            ->setLabel($article['label'])
                            ->setDescription($article['description'])
                            ->setTypeArticle($article['type'])
                            ->setBuyArticle($article['status_buy'])
                            ->setPriceHTSupplier($articlePurchasePrice)
                            ->setPriceHTCustomer($article['price'])
                            ->setTVASupplier($articlePurchaseTVA)
                            ->setTVACustomer($article['tva_tx'])
                            ->setStatus($article['status'] ? $article['status'] : '0')
                            ->setActivate('0')
                            ->setEtat('0')
                            ->setCreatedAt(new DateTimeImmutable(date('Y-m-d H:i:s')))
                            ->setParamApi($argumentId);

                        $em->persist($article_entity);
                    }
                }
                // -------------------- UPDATE ARTICLE----------------------

                else {
                    $updatedTimestamp = $occurence->getUpdatedAt() ?? 0;
                    // TEST
                    // $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp() - 1540000000) : 0;
                    $updatedTimestamp = $updatedTimestamp ? ($updatedTimestamp->getTimestamp()) : 0;

                    if ($article['date_modification'] > $updatedTimestamp) {
                        $io->info("Updating article " . $article['id']);
                        $occurenceArticle
                            ->setFkCategory($category)
                            ->setUuid('uuid')
                            ->setOrigin('dolifact')
                            ->setOriginId($article['id'])
                            ->setReference($article['ref'])
                            ->setLabel($article['label'])
                            ->setDescription($article['description'])
                            ->setTypeArticle($article['type'])
                            ->setBuyArticle($article['status_buy'])
                            ->setPriceHTSupplier($articlePurchasePrice)
                            ->setPriceHTCustomer($article['price'])
                            ->setTVASupplier($articlePurchaseTVA)
                            ->setTVACustomer($article['tva_tx'])
                            ->setStatus($article['status'] ? $article['status'] : '0')
                            // TEST
                            // ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', $updatedTimestamp)));
                            ->setUpdatedAt(new DateTimeImmutable(date('Y-m-d H:i:s', (int)$article['date_modification'])));

                        $em->persist($occurenceArticle);
                    }
                }
            } catch (\Exception $e) {
                $io->error('Failed to updated article : ' . $e->getMessage());
            }
            array_push($articleId, $article['id']);
        }

        // -------------------- CHECK ARTICLE ORIGIN_ID TO ID ->  UPDATE DeletedAT IF NOT FOUND ----------------------


        $articleOriginId = [];

        // Stock sous forme de talbeau d'objet les éléments de la class Article ou le champ "origin" a pour valeur dolifact 
        $occurenceArticleOriginId = $em->getRepository(Article::class)
            ->findBy(array(
                "origin" => 'dolifact',
                "paramApi" => $argumentId 

            ));

        // Pour chaque élement du tableau $occurenceArticleOriginId , reccupère l'originId de l'article et l'ajoute au tableau $articleOriginId 
        foreach ($occurenceArticleOriginId as $article) {
            array_push($articleOriginId, $article->getOriginId());
        }

        // Pour chaque élément du tableau $articleOriginId, crée un tableau d'objet article correspondant aux articles ayant pour valeur "originId" => $id ... 
        foreach ($articleOriginId as $id) {
            $occurenceArticleId = $em->getRepository(Article::class)
                ->findOneBy(array(
                    "originId" => $id,
                    "origin" => 'dolifact',
                    "paramApi" => $argumentId 

                ));

            // Si il y a l'élément $id dans le tableau $articleId alors deletedAt prend NULL
            if (in_array($id, $articleId)) {
                $occurenceArticleId
                    ->setDeletedAt(NULL);

            // Sinon deletedAt prend la date actuel 
            } else {
                $occurenceArticleId
                    ->setDeletedAt(new DateTimeImmutable(date('Y-m-d H:i:s')));
            }
            $em->persist($occurenceArticleId);
        }
        $em->flush();

        $io->success(sprintf('End'));

        return Command::SUCCESS;
    }
}
