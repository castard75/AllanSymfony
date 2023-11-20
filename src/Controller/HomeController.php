<?php

namespace App\Controller;

use App\DTO\TelephoneDTO;
use App\Entity\Controle;
use App\Entity\Employees;
use App\Entity\Contracts;
use App\Entity\Telephone;
use App\Form\ContactLinkingFormType;
use App\Form\TelephoneDTOType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
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
        $form = $this->createForm(ContactLinkingFormType::class, $controle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isXmlHttpRequest()) { // Logique pour une requête Ajax en cas de succès
                $entityManager->persist($controle);
                $entityManager->flush();
                $data = $serializer->serialize($controle, 'json');
                return new JsonResponse(['success' => true, 'data' => json_decode($data)]);
            }

        } else {
            if ($request->isXmlHttpRequest()) { // Logique pour une requête Ajax en cas d'erreur
                $errors = ""; // Récupérer les erreurs du formulaire
                return new JsonResponse(['success' => false, 'errors' => $errors]);
            }
        }


        $controls = $entityManager->getRepository(Controle::class)->findBy([], ['id' => 'DESC']);
        return $this->render('home/liaison.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
            'controls' => $controls,
        ]);
    }


    #[Route('/associate', name: 'app_associate')]
    public function associate(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {

        $telephones = $entityManager->getRepository(Telephone::class)->findAll();

        $forms = [];
        foreach ($telephones as $telephone) {
            $dto = (new TelephoneDTO())->setTelephone($telephone);
            $form = $this->createForm(TelephoneDTOType::class, $dto);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                if ($request->isXmlHttpRequest()) { // si traitement ajax success
                    $controle = (new Controle())
                        ->setTelephoneid($dto->getTelephone())
                        ->setContratid($dto->getContrat());
                    $entityManager->persist($controle);
                    $entityManager->flush();
                    $data = $serializer->serialize($controle, 'json');
                    return new JsonResponse(['success' => true, 'data' => json_decode($data)]);

                }
            }else {
                if ($request->isXmlHttpRequest()) { // si erreur traitement ajax
                    $errors = [];
                    foreach ($form->getErrors(true) as $error) {
                        $errors[] = $error->getMessage();
                    }
                    return new JsonResponse(['success' => false, 'errors' => $errors], Response::HTTP_BAD_REQUEST);
                }
            }

            $forms[$telephone->getId()] = $form->createView();
        }

        return $this->render('home/associate.html.twig', [
            'forms' => $forms,
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
