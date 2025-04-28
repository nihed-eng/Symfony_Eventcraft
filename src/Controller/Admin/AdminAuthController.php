<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/admin')]
class AdminAuthController extends AbstractController
{
    #[Route('/login', name: 'app_admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/register', name: 'app_admin_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($request->isMethod('POST')) {
<<<<<<< HEAD
<<<<<<< HEAD
=======
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $prenom = $request->request->get('prenom');
            $nom = $request->request->get('nom');

            // Validate required fields first
            if (!$email || !$password || !$prenom || !$nom) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_admin_register');
            }

            // Then validate CSRF token
            if (!$this->isCsrfTokenValid('admin_register', $request->request->get('_csrf_token'))) {
                $this->addFlash('error', 'Token CSRF invalide.');
=======
<<<<<<< HEAD
>>>>>>> Salles
            if (!$this->isCsrfTokenValid('admin_register', $request->request->get('_csrf_token'))) {
                $this->addFlash('error', 'Token CSRF invalide.');
                return $this->redirectToRoute('app_admin_register');
            }

            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $firstName = $request->request->get('firstName');
            $lastName = $request->request->get('lastName');
            $faceData = $request->request->get('face_data');

            // Validate required fields
            if (!$email || !$password || !$firstName || !$lastName || !$faceData) {
                $this->addFlash('error', 'Tous les champs sont obligatoires, y compris la photo du visage.');
=======
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $prenom = $request->request->get('prenom');
            $nom = $request->request->get('nom');

            // Validate required fields first
            if (!$email || !$password || !$prenom || !$nom) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('app_admin_register');
            }

            // Then validate CSRF token
            if (!$this->isCsrfTokenValid('admin_register', $request->request->get('_csrf_token'))) {
                $this->addFlash('error', 'Token CSRF invalide.');
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
                return $this->redirectToRoute('app_admin_register');
            }

            // Validate password requirements
            if (strlen($password) < 8 || 
                !preg_match('/[A-Z]/', $password) || 
                !preg_match('/[a-z]/', $password) || 
                !preg_match('/[0-9]/', $password)) {
                $this->addFlash('error', 'Le mot de passe ne respecte pas les critères de sécurité.');
                return $this->redirectToRoute('app_admin_register');
            }

            // Check if email already exists
            $existingUser = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
            if ($existingUser) {
                $this->addFlash('error', 'Cette adresse email est déjà utilisée.');
                return $this->redirectToRoute('app_admin_register');
            }

            $user = new Utilisateur();
            $user->setEmail($email)
<<<<<<< HEAD
<<<<<<< HEAD
=======
                ->setNom($nom)
                ->setPrenom($prenom)
=======
<<<<<<< HEAD
>>>>>>> Salles
                ->setNom($lastName)
                ->setPrenom($firstName)
=======
                ->setNom($nom)
                ->setPrenom($prenom)
>>>>>>> 6ab9b1d (Initial commit)
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
                ->setRole('ROLE_ADMIN')
                ->setPassword($userPasswordHasher->hashPassword($user, $password))
                ->setStatutCompte('active');

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Compte administrateur créé avec succès!');
            return $this->redirectToRoute('app_admin_login');
        }

        return $this->render('admin/auth/register.html.twig');
    }

    #[Route('/logout', name: 'app_admin_logout')]
    public function logout(): void
    {
        // This method can be blank - it will be intercepted by the logout key on your firewall
    }
}
