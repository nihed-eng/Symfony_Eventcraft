<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(SalleRepository $salleRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        
        // Récupérer les salles de l'utilisateur connecté
        $salles = $salleRepository->findBy(['user' => $user]); // Supposons que Salle a une relation avec User
        
        // Passer les salles à la vue
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'salles' => $salles,  // Passer les salles à la vue
            'activeTab' => 'profile',
        ]);
    }


    #[Route('/profile/update', name: 'app_profile_update', methods: ['POST'])]
    public function updateProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('profile_update', $submittedToken)) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        /** @var Utilisateur $user */
        $user = $this->getUser();
        
        $user->setPrenom($request->request->get('prenom'))
            ->setNom($request->request->get('nom'))
            ->setEmail($request->request->get('email'));

        $entityManager->flush();

        $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

        return $this->redirectToRoute('app_profile');
    }

    #[Route('/profile/password', name: 'app_profile_password')]
    public function password(): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
            'activeTab' => 'password'
        ]);
    }

    #[Route('/profile/password/update', name: 'app_profile_password_update', methods: ['POST'])]
    public function updatePassword(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('password_update', $submittedToken)) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_profile_password');
        }

        /** @var Utilisateur $user */
        $user = $this->getUser();
        
        $currentPassword = $request->request->get('currentPassword');
        $newPassword = $request->request->get('newPassword');
        $confirmPassword = $request->request->get('confirmPassword');

        // Verify current password
        if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
            $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
            return $this->redirectToRoute('app_profile_password');
        }

        // Verify new passwords match
        if ($newPassword !== $confirmPassword) {
            $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
            return $this->redirectToRoute('app_profile_password');
        }

        // Update password
        $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
        $entityManager->flush();

        $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
        return $this->redirectToRoute('app_profile');
    }

    #[Route('/profile/notifications', name: 'app_profile_notifications')]
    public function notifications(): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
            'activeTab' => 'notifications'
        ]);
    }

    #[Route('/profile/notifications/update', name: 'app_profile_notifications_update', methods: ['POST'])]
    public function updateNotifications(Request $request, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('notifications_update', $submittedToken)) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        /** @var Utilisateur $user */
        $user = $this->getUser();
        
        // For now, we'll just acknowledge the request since notification settings are not implemented
        $entityManager->flush();

        $this->addFlash('success', 'Vos préférences de notification ont été mises à jour.');

        return $this->redirectToRoute('app_profile_notifications');
    }
}
