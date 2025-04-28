<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/reclamation')]
#[IsGranted('ROLE_USER')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $reclamations = $entityManager
            ->getRepository(Reclamation::class)
<<<<<<< HEAD
<<<<<<< HEAD
=======
            ->findBy(['user' => $this->getUser()], ['date' => 'DESC']);
=======
<<<<<<< HEAD
>>>>>>> Salles
            ->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC']);
=======
            ->findBy(['user' => $this->getUser()], ['date' => 'DESC']);
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setUser($this->getUser());
<<<<<<< HEAD
<<<<<<< HEAD
=======
        $reclamation->setDate(new \DateTime());
        $reclamation->setStatut('pending');
=======
<<<<<<< HEAD
>>>>>>> Salles
=======
        $reclamation->setDate(new \DateTime());
        $reclamation->setStatut('pending');
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
<<<<<<< HEAD
>>>>>>> Salles
            $entityManager->persist($reclamation);
            $entityManager->flush();

            $this->addFlash('success', 'Your complaint has been submitted successfully.');
            return $this->redirectToRoute('app_reclamation_index');
=======
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
            try {
                $entityManager->persist($reclamation);
                $entityManager->flush();
                $this->addFlash('success', 'Your complaint has been submitted successfully.');
                return $this->redirectToRoute('app_reclamation_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred: ' . $e->getMessage());
            }
<<<<<<< HEAD
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
        }

        return $this->render('reclamation/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        if ($reclamation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot view this complaint.');
        }

        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
}
