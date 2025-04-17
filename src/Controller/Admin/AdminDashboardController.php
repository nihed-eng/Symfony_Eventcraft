<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
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
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['date' => 'DESC']);

        return $this->render('admin/dashboard/index.html.twig', [
            'users' => $users,
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/users', name: 'app_admin_users')]
    public function users(EntityManagerInterface $entityManager): HttpResponse
    {
        $users = $entityManager->getRepository(Utilisateur::class)->findAll();

        return $this->render('admin/dashboard/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/reclamations', name: 'app_admin_reclamations')]
    public function reclamations(EntityManagerInterface $entityManager): HttpResponse
    {
        $reclamations = $entityManager->getRepository(Reclamation::class)->findBy([], ['date' => 'DESC']);

        return $this->render('admin/dashboard/reclamations.html.twig', [
            'reclamations' => $reclamations,
        ]);
    }

    #[Route('/user/{id}/ban', name: 'app_admin_user_ban', methods: ['POST'])]
    public function banUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('ban-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        if ($user->getRole() === 'ROLE_ADMIN') {
            $this->addFlash('error', 'Vous ne pouvez pas bannir un administrateur.');
            return $this->redirectToRoute('app_admin_users');
        }

        $user->setStatutCompte('banned');
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été banni avec succès.');
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/unban', name: 'app_admin_user_unban', methods: ['POST'])]
    public function unbanUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('unban-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $user->setStatutCompte('active');
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été débanni avec succès.');
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/delete', name: 'app_admin_user_delete', methods: ['POST'])]
    public function deleteUser(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        if (!$this->isCsrfTokenValid('delete-user-' . $user->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        if ($user->getRole() === 'ROLE_ADMIN') {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer un administrateur.');
            return $this->redirectToRoute('app_admin_users');
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été supprimé avec succès.');
        return $this->redirectToRoute('app_admin_users');
    }

    #[Route('/user/{id}/toggle-ban', name: 'app_admin_user_toggle_ban', methods: ['POST'])]
    public function toggleUserBan(Utilisateur $user, Request $request, EntityManagerInterface $entityManager): HttpResponse
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

    #[Route('/reclamation/{id}/respond', name: 'app_admin_reclamation_respond', methods: ['POST'])]
    public function respondToReclamation(Reclamation $reclamation, Request $request, EntityManagerInterface $entityManager): HttpResponse
    {
        $responseContent = $request->request->get('response');
        if (!$responseContent) {
            $this->addFlash('error', 'La réponse ne peut pas être vide.');
            return $this->redirectToRoute('app_admin_reclamations');
        }

        $response = new Response();
        $response->setContenu($responseContent);
        $response->setReclamation($reclamation);

        $reclamation->setStatut('resolved');
        $reclamation->setResponse($response);

        $entityManager->persist($response);
        $entityManager->flush();

        $this->addFlash('success', 'Votre réponse a été envoyée avec succès.');
        return $this->redirectToRoute('app_admin_reclamations');
    }
}
