<?php

namespace App\Controller;

use App\Service\GoogleAuthService;
use App\Security\AppCustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\FormLoginAuthenticator;
<<<<<<< HEAD
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
=======
<<<<<<< HEAD
=======
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

class GoogleAuthController extends AbstractController
{
    #[Route('/connect/google', name: 'connect_google')]
    public function connectAction(GoogleAuthService $googleAuthService): Response
    {
        return $this->redirect($googleAuthService->getAuthorizationUrl());
    }

    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectCheckAction(
        Request $request,
        GoogleAuthService $googleAuthService,
        UserAuthenticatorInterface $userAuthenticator,
        AppCustomAuthenticator $authenticator
    ): Response {
        try {
<<<<<<< HEAD
=======
<<<<<<< HEAD
            $user = $googleAuthService->handleCallback(
                $request->query->get('state'),
                $request->query->get('code')
            );
=======
>>>>>>> c139a4e (Résolution des conflits)
            // Debug the incoming parameters
            $state = $request->query->get('state');
            $code = $request->query->get('code');
            
            if (!$state || !$code) {
                $this->addFlash('error', 'Paramètres de connexion Google manquants.');
                return $this->redirectToRoute('app_login');
            }
            
            $user = $googleAuthService->handleCallback($state, $code);
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)

            if (!$user) {
                $this->addFlash('error', 'Une erreur est survenue lors de la connexion avec Google.');
                return $this->redirectToRoute('app_login');
            }

            // Authenticate the user
            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

            $this->addFlash('success', 'Connexion réussie avec Google !');
            return $this->redirectToRoute('app_home');

        } catch (\Exception $e) {
<<<<<<< HEAD
            // Log the detailed exception
            $this->addFlash('error', 'Une erreur est survenue lors de la connexion avec Google: ' . $e->getMessage());
            return $this->redirectToRoute('app_login');
        }
    }
=======
<<<<<<< HEAD
            $this->addFlash('error', 'Une erreur est survenue lors de la connexion avec Google.');
            return $this->redirectToRoute('app_login');
        }
    }
=======
            // Log the detailed exception
            $this->addFlash('error', 'Une erreur est survenue lors de la connexion avec Google: ' . $e->getMessage());
            return $this->redirectToRoute('app_login');
        }
    }
>>>>>>> c139a4e (Résolution des conflits)
    
    #[Route('/debug/google/users', name: 'debug_google_users')]
    public function debugGoogleUsers(UtilisateurRepository $utilisateurRepository): Response
    {
        // This route is for debugging only and should be removed in production
        if ($this->getParameter('kernel.environment') !== 'dev') {
            throw $this->createAccessDeniedException();
        }
        
        $users = $utilisateurRepository->findAll();
        $userData = [];
        
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'nom' => $user->getNom(),
                'prenom' => $user->getPrenom(),
                'role' => $user->getRole(),
                'statut' => $user->getStatutCompte(),
            ];
        }
        
        return new JsonResponse([
            'user_count' => count($users),
            'users' => $userData
        ]);
    }
<<<<<<< HEAD
=======
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
}