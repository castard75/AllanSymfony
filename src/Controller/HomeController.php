<?php

namespace App\Controller;

use App\Entity\Controle;
use App\Entity\Employees;
use App\Entity\Contracts;
use App\Form\ContactLinkingFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request,EntityManagerInterface  $entityManager): Response
    {

       
        $ListeEmployee = $entityManager->getRepository(Employees::class)->findAll();
        $ListeContracts = $entityManager->getRepository(Contracts::class)->findAll();

        // var_dump($ListeContracts);

        $controle = new Controle();
        $form = $this->createForm(ContactLinkingFormType::class,$controle);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($controle);
            $entityManager->flush();
            $this->addFlash('success', 'Votre liaison a bien été enregistrée');
            return $this->redirectToRoute('app_home');
        }


        // Le bouton dans votre template appelle getData lorsque cliqué
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'ListeContracts' => $ListeContracts,
            'form' => $form->createView(),
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
