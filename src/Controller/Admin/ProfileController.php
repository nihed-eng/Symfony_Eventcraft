<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
#[Route('/admin')]
class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_admin_profile')]
    public function index(): Response
    {
        return $this->render('admin/profile/index.html.twig', [
            'user' => $this->getUser(),
            'activeTab' => 'profile'
        ]);
    }

    #[Route('/profile/update', name: 'app_admin_profile_update', methods: ['POST'])]
    public function updateProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('admin_profile_update', $submittedToken)) {
            throw new InvalidCsrfTokenException('Invalid CSRF token');
        }

        /** @var User $user */
        $user = $this->getUser();
        
        $user->setFirstName($request->request->get('firstName'))
            ->setLastName($request->request->get('lastName'))
            ->setEmail($request->request->get('email'));

        $entityManager->flush();

        $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

        return $this->redirectToRoute('app_admin_profile');
    }

    #[Route('/profile/password', name: 'app_admin_profile_password')]
    public function password(): Response
    {
        return $this->render('admin/profile/index.html.twig', [
            'user' => $this->getUser(),
            'activeTab' => 'password'
        ]);
    }

    #[Route('/profile/password/update', name: 'app_admin_profile_password_update', methods: ['POST'])]
    public function updatePassword(
        Request $request, 
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $submittedToken = $request->request->get('_token');
        if (!$this->isCsrfTokenValid('admin_password_update', $submittedToken)) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_admin_profile_password');
        }

        /** @var User $user */
        $user = $this->getUser();
        
        $currentPassword = $request->request->get('currentPassword');
        $newPassword = $request->request->get('newPassword');
        $confirmPassword = $request->request->get('confirmPassword');

        // Verify current password
        if (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
            $this->addFlash('error', 'Le mot de passe actuel est incorrect.');
            return $this->redirectToRoute('app_admin_profile_password');
        }

        // Verify new passwords match
        if ($newPassword !== $confirmPassword) {
            $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas.');
            return $this->redirectToRoute('app_admin_profile_password');
        }

        // Update password
        $user->setPassword($passwordHasher->hashPassword($user, $newPassword));
        $entityManager->flush();

        $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
        return $this->redirectToRoute('app_admin_profile');
    }
}
