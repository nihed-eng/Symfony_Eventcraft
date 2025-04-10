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
            $user = $googleAuthService->handleCallback(
                $request->query->get('state'),
                $request->query->get('code')
            );

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
            $this->addFlash('error', 'Une erreur est survenue lors de la connexion avec Google.');
            return $this->redirectToRoute('app_login');
        }
    }
}