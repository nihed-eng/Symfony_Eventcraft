<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Service\EmailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use SymfonyCasts\Bundle\ResetPassword\Controller\ResetPasswordControllerTrait;
use SymfonyCasts\Bundle\ResetPassword\Exception\ResetPasswordExceptionInterface;
use SymfonyCasts\Bundle\ResetPassword\Exception\TooManyPasswordRequestsException;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;
use Psr\Log\LoggerInterface;

#[Route('/reset-password')]
class ResetPasswordController extends AbstractController
{
    use ResetPasswordControllerTrait;

    public function __construct(
        private ResetPasswordHelperInterface $resetPasswordHelper,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private EmailService $emailService
    ) {
    }

    #[Route('', name: 'app_forgot_password_request')]
    public function request(Request $request): Response
    {
        // Display form for user to enter email
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            if (!$email) {
                $this->addFlash('reset_password_error', 'Veuillez entrer une adresse email.');
                return $this->redirectToRoute('app_forgot_password_request');
            }

            // Look for user with that email
            $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);

            // Do not reveal whether a user account was found or not
            if (!$user) {
                $this->logger->info('Reset password requested for non-existing email: ' . $email);
                $this->addFlash('reset_password_error', 'Si un compte existe avec cette adresse email, un code de vérification vous sera envoyé.');
                return $this->redirectToRoute('app_verify_code', ['email' => $email]);
            }

            try {
                $resetToken = $this->resetPasswordHelper->generateResetToken($user);
                
                // Generate a 6-digit verification code
                $verificationCode = sprintf('%06d', mt_rand(100000, 999999));
                
                // Store verification code and token info in session
                $tokenData = [
                    'token' => $resetToken->getToken(),
                    'code' => $verificationCode,
                    'email' => $email,
                    'expirationMessageKey' => $resetToken->getExpirationMessageKey(),
                    'expirationMessageData' => $resetToken->getExpirationMessageData(),
                    'expiresAt' => $resetToken->getExpiresAt()->getTimestamp(),
                    'userIdentifier' => $user->getId()
                ];
                $request->getSession()->set('reset_password_data', $tokenData);

                // Development mode - show verification code directly
                if ($this->getParameter('kernel.environment') === 'dev') {
                    $this->logger->info('DEV MODE: Verification code for ' . $email . ': ' . $verificationCode);
                    $this->addFlash('dev_verification_code', $verificationCode);
                }

                // Send verification code via email using our EmailService
                $emailSent = $this->emailService->sendVerificationEmail(
                    $user->getEmail(), 
                    $verificationCode, 
                    $resetToken->getExpiresAt()
                );

                if ($emailSent || $this->getParameter('kernel.environment') === 'dev') {
                    if ($emailSent) {
                        $this->addFlash('success', 'Un code de vérification a été envoyé à votre adresse email.');
                    } else if ($this->getParameter('kernel.environment') === 'dev') {
                        $this->addFlash('warning', 'L\'envoi d\'email a échoué, mais en mode développement, vous pouvez utiliser le code de vérification affiché ci-dessus.');
                    }
                    return $this->redirectToRoute('app_verify_code', ['email' => $email]);
                } else {
                    $this->addFlash('reset_password_error', 'Une erreur est survenue lors de l\'envoi de l\'email. Veuillez réessayer plus tard.');
                    return $this->redirectToRoute('app_forgot_password_request');
                }

            } catch (TooManyPasswordRequestsException $e) {
                // Special handling for too many requests exception
                $this->logger->info('Too many reset password requests for email: ' . $email);
                
                $waitTime = ceil($e->getAvailableAt()->getTimestamp() - time());
                $waitMinutes = max(1, ceil($waitTime / 60));
                
                $errorMessage = 'Vous avez déjà demandé une réinitialisation de mot de passe récemment. ';
                $errorMessage .= 'Veuillez vérifier votre email ou réessayer dans ' . $waitMinutes . ' minute' . ($waitMinutes > 1 ? 's' : '') . '.';
                
                $this->addFlash('reset_password_error', $errorMessage);
                
                // In development, provide a way to clear the throttling
                if ($this->getParameter('kernel.environment') === 'dev') {
                    $resetUrl = $this->generateUrl('app_clear_password_reset', ['email' => $email]);
                    $this->addFlash('reset_password_info', 'En mode développement, vous pouvez <a href="' . $resetUrl . '">forcer la suppression</a> des demandes précédentes.');
                }
                
                return $this->redirectToRoute('app_forgot_password_request');
            } catch (ResetPasswordExceptionInterface $e) {
                // Enhanced error message with more details
                $errorMessage = 'Une erreur est survenue lors de la réinitialisation du mot de passe: ' . $e->getReason();
                
                $this->logger->error('Reset password error: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'reason' => $e->getReason(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                $this->addFlash('reset_password_error', $errorMessage);
                return $this->redirectToRoute('app_forgot_password_request');
            } catch (\Exception $e) {
                // Enhanced error message for general exceptions
                $errorMessage = 'Une erreur technique est survenue lors de la réinitialisation du mot de passe.';
                
                if ($this->getParameter('kernel.environment') === 'dev') {
                    $errorMessage .= ' (' . get_class($e) . ': ' . $e->getMessage() . ')';
                }
                
                $this->logger->error('Unexpected exception: ' . $e->getMessage(), [
                    'exception' => get_class($e),
                    'trace' => $e->getTraceAsString()
                ]);
                
                $this->addFlash('reset_password_error', $errorMessage);
                return $this->redirectToRoute('app_forgot_password_request');
            }
        }

        return $this->render('auth/forgot_password.html.twig');
    }

    #[Route('/verify-code', name: 'app_verify_code')]
    public function verifyCode(Request $request): Response
    {
        $email = $request->query->get('email');
        
        if (!$email) {
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        $resetData = $request->getSession()->get('reset_password_data');
        
        // If no reset data or email mismatch or expired, redirect to request page
        if (!$resetData || $resetData['email'] !== $email || time() > $resetData['expiresAt']) {
            $this->addFlash('reset_password_error', 'Code de vérification invalide ou expiré.');
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        if ($request->isMethod('POST')) {
            $submittedCode = $request->request->get('code');
            
            if (empty($submittedCode)) {
                $this->addFlash('reset_password_error', 'Veuillez entrer le code de vérification.');
                return $this->render('auth/verify_code.html.twig', ['email' => $email]);
            }
            
            if ($submittedCode === $resetData['code']) {
                // Code verified, mark as verified in session
                $resetData['verified'] = true;
                $request->getSession()->set('reset_password_data', $resetData);
                
                return $this->redirectToRoute('app_reset_password_final', ['email' => $email]);
            }
            
            $this->addFlash('reset_password_error', 'Code de vérification incorrect.');
        }
        
        return $this->render('auth/verify_code.html.twig', ['email' => $email]);
    }

    #[Route('/reset-final', name: 'app_reset_password_final')]
    public function resetFinal(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $email = $request->query->get('email');
        
        if (!$email) {
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        $resetData = $request->getSession()->get('reset_password_data');
        
        // Check if reset data exists, email matches, code is verified, and token is not expired
        if (!$resetData || $resetData['email'] !== $email || !isset($resetData['verified']) || time() > $resetData['expiresAt']) {
            $this->addFlash('reset_password_error', 'Votre session de réinitialisation de mot de passe a expiré ou est invalide.');
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        $user = $this->entityManager->getRepository(Utilisateur::class)->find($resetData['userIdentifier']);
        
        if (!$user) {
            $this->addFlash('reset_password_error', 'Une erreur est survenue lors de la réinitialisation du mot de passe.');
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        if ($request->isMethod('POST')) {
            $password = $request->request->get('password');
            $passwordConfirm = $request->request->get('password_confirm');
            
            if (!$password || !$passwordConfirm) {
                $this->addFlash('reset_password_error', 'Veuillez entrer un mot de passe.');
                return $this->render('auth/reset_password_final.html.twig');
            }
            
            if ($password !== $passwordConfirm) {
                $this->addFlash('reset_password_error', 'Les mots de passe ne correspondent pas.');
                return $this->render('auth/reset_password_final.html.twig');
            }
            
            try {
                // Update the password
                $encodedPassword = $passwordHasher->hashPassword(
                    $user,
                    $password
                );
                
                $user->setPassword($encodedPassword);
                $this->entityManager->flush();
                
                // Remove the reset request from database
                $this->resetPasswordHelper->removeResetRequest($resetData['token']);
                
                // Clear session data
                $request->getSession()->remove('reset_password_data');
                
                $this->addFlash('success', 'Votre mot de passe a été réinitialisé avec succès.');
                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                $this->logger->error('Password update failed: ' . $e->getMessage());
                $this->addFlash('reset_password_error', 'Une erreur est survenue lors de la mise à jour de votre mot de passe.');
                return $this->render('auth/reset_password_final.html.twig');
            }
        }
        
        return $this->render('auth/reset_password_final.html.twig');
    }

    #[Route('/debug-token-info', name: 'app_debug_token_info')]
    public function debugTokenInfo(Request $request): Response
    {
        // Only available in dev environment
        if ($this->getParameter('kernel.environment') !== 'dev') {
            throw $this->createAccessDeniedException();
        }
        
        $tokenFromSession = $this->getTokenFromSession();
        $tokenObjectFromSession = $this->getTokenObjectFromSession();
        $devTokenData = $request->getSession()->get('dev_reset_token_data');
        
        // Get all session data for debugging
        $sessionData = [];
        foreach ($request->getSession()->all() as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                $sessionData[$key] = $value;
            } else {
                $sessionData[$key] = gettype($value) . ' (object)';
            }
        }
        
        return $this->render('auth/debug_token_info.html.twig', [
            'tokenFromSession' => $tokenFromSession,
            'tokenObjectFromSession' => $tokenObjectFromSession ? 'Set (object)' : 'Not set',
            'devTokenData' => $devTokenData,
            'sessionData' => $sessionData,
        ]);
    }

    /**
     * Special development only route to see all verification codes
     */
    #[Route('/dev/codes', name: 'app_dev_verification_codes')]
    public function devVerificationCodes(Request $request): Response
    {
        // Only available in dev environment
        if ($this->getParameter('kernel.environment') !== 'dev') {
            throw $this->createAccessDeniedException('This action is only available in the dev environment');
        }
        
        $resetData = $request->getSession()->get('reset_password_data');
        
        // Get all session data for debugging
        $sessionData = [];
        foreach ($request->getSession()->all() as $key => $value) {
            if (is_scalar($value) || is_null($value)) {
                $sessionData[$key] = $value;
            } else if (is_array($value)) {
                $sessionData[$key] = json_encode($value);
            } else {
                $sessionData[$key] = gettype($value) . ' (object)';
            }
        }
        
        return $this->render('auth/dev_verification_codes.html.twig', [
            'resetData' => $resetData,
            'sessionData' => $sessionData,
        ]);
    }

    /**
     * Development-only route to clear password reset requests
     */
    #[Route('/dev/clear-request/{email}', name: 'app_clear_password_reset')]
    public function clearPasswordResetRequest(string $email): Response
    {
        // Only available in dev environment
        if ($this->getParameter('kernel.environment') !== 'dev') {
            throw $this->createAccessDeniedException('This action is only available in the dev environment');
        }
        
        $user = $this->entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $email]);
        
        if (!$user) {
            $this->addFlash('reset_password_error', 'Utilisateur non trouvé');
            return $this->redirectToRoute('app_forgot_password_request');
        }
        
        // Clear all reset requests for this user
        $this->resetPasswordHelper->removeResetPasswordRequest($user);
        
        $this->addFlash('success', 'Les demandes précédentes de réinitialisation de mot de passe ont été supprimées.');
        return $this->redirectToRoute('app_forgot_password_request');
    }
}