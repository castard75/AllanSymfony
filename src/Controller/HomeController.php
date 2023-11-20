<?php

namespace App\Controller;

use App\Entity\Controle;
use App\Entity\Employees;
use App\Entity\Contracts;
use App\Entity\Telephone;
use App\Form\ContactLinkingFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {


        $ListeEmployee = $entityManager->getRepository(Employees::class)->findAll();
        $ListeContracts = $entityManager->getRepository(Contracts::class)->findAll();

        // var_dump($ListeContracts);


        // Le bouton dans votre template appelle getData lorsque cliqué
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'ListeContracts' => $ListeContracts,
        ]);
    }

    #[Route('/liaison', name: 'app_liaison')]
    public function liaison(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        $controle = new Controle();
    //creation du formulaire
        $form = $this->createForm(ContactLinkingFormType::class, $controle); 
        //lecture de la data
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isXmlHttpRequest()) { // Logique pour une requête Ajax en cas de succès
                $telephoneId = $request->get('telephoneId');

                
                $telephone = $entityManager->getRepository(Telephone::class)->findOneBy(['id' => $telephoneId]);

                $controle->setTelephoneid( $telephone);
                $entityManager->persist($controle);
                $entityManager->flush();
                $data = $serializer->serialize($controle, 'json'); //envoie de la table controle en JSON
                return new JsonResponse(['success' => true, 'data' => json_decode($data)]);
            }

        } else {
            if ($request->isXmlHttpRequest()) { // Logique pour une requête Ajax en cas d'erreur
                $errors = ""; // Récupérer les erreurs du formulaire
                return new JsonResponse(['success' => false, 'errors' => $errors]);
            }
        }


        $controls = $entityManager->getRepository(Controle::class)->findBy([], ['id' => 'DESC']);
        $Telephones =$entityManager->getRepository(Telephone::class)->findAll();
        return $this->render('home/liaison.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
            'controls' => $controls,
            'telephones' => $Telephones
        ]);
    }


}