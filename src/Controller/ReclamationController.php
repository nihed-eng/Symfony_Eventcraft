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
            ->findBy(['user' => $this->getUser()], ['date' => 'DESC']);

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setUser($this->getUser());
        $reclamation->setDate(new \DateTime());
        $reclamation->setStatut('pending');
        
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $entityManager->persist($reclamation);
                $entityManager->flush();
                $this->addFlash('success', 'Your complaint has been submitted successfully.');
                return $this->redirectToRoute('app_reclamation_index');
            } catch (\Exception $e) {
                $this->addFlash('error', 'An error occurred: ' . $e->getMessage());
            }
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

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        // Security check - only the owner can edit their reclamation
        if ($reclamation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot edit this complaint.');
        }
        
        // Only allow editing of pending reclamations
        if ($reclamation->getStatut() !== 'pending') {
            $this->addFlash('error', 'You cannot edit a complaint that has been resolved.');
            return $this->redirectToRoute('app_reclamation_index');
        }
        
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Your complaint has been updated successfully.');
            return $this->redirectToRoute('app_reclamation_index');
        }
        
        return $this->render('reclamation/edit.html.twig', [
            'form' => $form,
            'reclamation' => $reclamation,
        ]);
    }
    
    #[Route('/{id}/delete', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        // Security check - only the owner can delete their reclamation
        if ($reclamation->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You cannot delete this complaint.');
        }
        
        // Check CSRF token
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
            $this->addFlash('success', 'Your complaint has been deleted successfully.');
        } else {
            $this->addFlash('error', 'Invalid token. Please try again.');
        }
        
        return $this->redirectToRoute('app_reclamation_index');
    }
}
