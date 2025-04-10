<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\ResetPasswordRequest;
use App\Repository\UtilisateurRepository;
use App\Repository\ResetPasswordRequestRepository;
use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class ResetPasswordController extends AbstractController
{
    private $emailService;

    public function __construct(
        private UtilisateurRepository $userRepository,
        private ResetPasswordRequestRepository $resetPasswordRequestRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private LoggerInterface $logger
    ) {
        $this->emailService = new EmailService();
    }

    #[Route('/reset-password', name: 'app_forgot_password', methods: ['GET', 'POST'])]
    public function request(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $user = $this->userRepository->findOneBy(['email' => $email]);

            if ($user) {
                // Create a new reset password request
                $resetRequest = new ResetPasswordRequest($user);
                $this->resetPasswordRequestRepository->save($resetRequest, true);
                
                // Store the request in session
                $request->getSession()->set('reset_password_code', [
                    'code' => $resetRequest->getVerificationCode(),
                    'email' => $email,
                    'expires_at' => $resetRequest->getExpiresAt()->getTimestamp()
                ]);

                try {
                    // Send verification code email using our EmailService
                    $this->emailService->sendVerificationEmail($user->getEmail(), $code);
                    
                    $this->logger->info('Reset password email sent successfully to ' . $email);
                    $this->addFlash('success', 'Un code de vérification a été envoyé à votre adresse e-mail.');
                    return $this->redirectToRoute('app_verify_code', ['email' => $user->getEmail()]);
                } catch (\Exception $e) {
                    $this->logger->error('Failed to send reset password email: ' . $e->getMessage());
                    $this->addFlash('reset_password_error', 'Une erreur est survenue lors de l\'envoi de l\'e-mail. Veuillez réessayer plus tard.');
                    return $this->redirectToRoute('app_forgot_password');
                }
            }

            // Don't reveal if the email exists
            $this->addFlash('reset_password_error', 'Si un compte existe avec cette adresse e-mail, un code de vérification vous sera envoyé.');
            return $this->redirectToRoute('app_verify_code', ['email' => $email]);
        }

        return $this->render('auth/forgot_password.html.twig');
    }

    #[Route('/verify-code', name: 'app_verify_code', methods: ['GET', 'POST'])]
    public function verifyCode(Request $request): Response
    {
        $email = $request->query->get('email');
        if (!$email) {
            return $this->redirectToRoute('app_forgot_password');
        }

        $resetData = $request->getSession()->get('reset_password_code');
        if (!$resetData || $resetData['email'] !== $email || time() > $resetData['expires_at']) {
            $this->addFlash('verify_code_error', 'Code de vérification invalide ou expiré.');
            return $this->redirectToRoute('app_forgot_password');
        }

        if ($request->isMethod('POST')) {
            $submittedCode = $request->request->get('code');
            $user = $this->userRepository->findOneBy(['email' => $resetData['email']]);
            $resetRequest = $this->resetPasswordRequestRepository->findValidRequest($user);

            if ($resetRequest && $submittedCode === $resetRequest->getVerificationCode()) {
                // Mark code as verified
                $resetRequest->setIsVerified(true);
                $this->resetPasswordRequestRepository->save($resetRequest, true);
                $resetData['verified'] = true;
                $request->getSession()->set('reset_password_code', $resetData);

                return $this->redirectToRoute('app_reset_password', ['email' => $email]);
            }

            $this->addFlash('verify_code_error', 'Code de vérification incorrect.');
        }

        return $this->render('auth/verify_code.html.twig');
    }

    #[Route('/reset-password/reset', name: 'app_reset_password', methods: ['GET', 'POST'])]
    public function reset(Request $request): Response
    {
        $email = $request->query->get('email');
        if (!$email) {
            return $this->redirectToRoute('app_forgot_password');
        }

        $resetData = $request->getSession()->get('reset_password_code');
        if (!$resetData || $resetData['email'] !== $email || !isset($resetData['verified']) || time() > $resetData['expires_at']) {
            return $this->redirectToRoute('app_forgot_password');
        }

        $user = $this->userRepository->findOneBy(['email' => $email]);
        if (!$user) {
            return $this->redirectToRoute('app_forgot_password');
        }

        if ($request->isMethod('POST')) {
            $password = $request->request->get('password');
            $passwordConfirm = $request->request->get('password_confirm');

            if ($password !== $passwordConfirm) {
                $this->addFlash('reset_password_error', 'Les mots de passe ne correspondent pas.');
                return $this->render('auth/reset_password.html.twig');
            }

            // Update password
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
            $this->userRepository->save($user, true);

            // Clear reset password data from session
            $request->getSession()->remove('reset_password_code');

            $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/reset_password.html.twig');
    }
}