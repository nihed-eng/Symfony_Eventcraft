<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Reclamation;
use App\Entity\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')]
class AdminDashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(EntityManagerInterface $entityManager): HttpResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();
        
        // Check if Reclamation entity and repository exist
        try {
            $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['createdAt' => 'DESC']);
        } catch (\Exception $e) {
            // If there's an error, set reclamations to an empty array
            $reclamations = [];
        }

        return $this->render('admin/dashboard/index.html.twig', [
            'users' => $users,
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/users', name: 'app_admin_users')]
    public function users(EntityManagerInterface $entityManager): HttpResponse
    {
        $users = $entityManager->getRepository(User::class)->findAll();

        return $this->render('admin/dashboard/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/reclamations', name: 'app_admin_reclamations')]
    public function reclamations(EntityManagerInterface $entityManager): HttpResponse
    {
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('admin/dashboard/reclamations.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/reclamation/{id}/respond', name: 'app_admin_reclamation_respond', methods: ['POST'])]
    public function respondToReclamation(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('respond-reclamation-' . $reclamation->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        $responseContent = $request->request->get('response');
        if (empty($responseContent)) {
            $this->addFlash('error', 'La réponse ne peut pas être vide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        // Check if reclamation already has a response
        if ($reclamation->getResponse() !== null) {
            $this->addFlash('error', 'Cette réclamation a déjà été traitée.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        // Create new response
        $response = new Response();
        $response->setContent($responseContent);
        $response->setRespondedBy($this->getUser());
        $response->setReclamation($reclamation);
        
        // Update reclamation status
        $reclamation->setStatus('resolved');
        
        // Persist the response
        $entityManager->persist($response);
        $entityManager->flush();

        $this->addFlash('success', 'Réponse envoyée avec succès.');
        return $this->redirectToRoute('app_admin_reclamations');
    }

    #[Route('/user/{id}/delete', name: 'app_admin_user_delete', methods: ['POST'])]
    public function deleteUser(User $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_users');
        }

        if ($user === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer votre propre compte.');
            return $this->redirectToRoute('app_admin_users');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'Utilisateur supprimé avec succès.');
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/toggle-ban', name: 'app_admin_user_toggle_ban', methods: ['POST'])]
    public function toggleUserBan(User $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('toggle-ban-user-' . $user->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_users');
        }

        if ($user === $this->getUser()) {
            $this->addFlash('error', 'Vous ne pouvez pas bannir votre propre compte.');
            return $this->redirectToRoute('app_admin_users');
        }

        // Toggle the user's status
        $newStatus = $user->getStatutCompte() === 'banned' ? 'active' : 'banned';
        $user->setStatutCompte($newStatus);
        
        $entityManager->flush();

        $message = $newStatus === 'banned' ? 'Utilisateur banni avec succès.' : 'Utilisateur réactivé avec succès.';
        $this->addFlash('success', $message);
        
        return $this->redirectToRoute('app_admin_users');
    }
}
