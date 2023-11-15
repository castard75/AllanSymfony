<?php

namespace App\Controller;

use App\Entity\Employees;
use App\Entity\Contracts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(EntityManagerInterface  $entityManager): Response
    {

       
        $ListeEmployee = $entityManager->getRepository(Employees::class)->findAll();
        $ListeContracts = $entityManager->getRepository(Contracts::class)->findAll();

        // var_dump($ListeContracts);



        // Le bouton dans votre template appelle getData lorsque cliqué
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'ListeContracts' => $ListeContracts
        ]);
    }

    // public function getData(): Response
    // {
    //     // Accéder à l'EntityManager de Doctrine
    //     $entityManager = $this->getDoctrine()->getManager();

    //     // Récupérer toutes les données de la table contracts
    //     $contracts = $entityManager->getRepository(Contract::class)->findAll();

    //     // Vous pouvez maintenant utiliser $contracts comme nécessaire
    //     $tab = []; // Initialisation de votre tableau
    //     foreach ($contracts as $contract) {
    //         // Ajoutez chaque contrat au tableau $tab
    //         $tab[] = $contract->getData(); // Vous devrez ajuster cela en fonction de votre entité Contract
    //     }

    //     // Restituer les données dans une réponse (exemple avec JsonResponse)
    //     return $this->json($tab);
    // }
}
