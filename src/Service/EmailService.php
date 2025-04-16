<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    private string $senderEmail;
    private string $senderName;

    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
        private LoggerInterface $logger
    ) {
        $this->senderEmail = $this->params->get('app.mail_from_address', 'ayadi.baha35@gmail.com');
        $this->senderName = $this->params->get('app.mail_from_name', 'EventCraft');
    }

    /**
     * Send verification email with a code
     * 
     * @param string $toEmail Email address of the recipient
     * @param string $verificationCode The code to verify
     * @param \DateTimeInterface|null $expiresAt When the code expires
     * @return bool Whether the email was sent successfully
     */
    public function sendVerificationEmail(string $toEmail, string $verificationCode, ?\DateTimeInterface $expiresAt = null): bool
    {
        try {
            $email = (new Email())
                ->from(new Address($this->senderEmail, $this->senderName))
                ->to($toEmail)
                ->subject('Code de vérification pour réinitialiser votre mot de passe')
                ->html($this->createVerificationEmailBody($verificationCode, $expiresAt));

            $this->mailer->send($email);
            
            $this->logger->info('Verification email sent successfully to: ' . $toEmail);
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Failed to send verification email: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Create the HTML body for the verification email
     */
    private function createVerificationEmailBody(string $verificationCode, ?\DateTimeInterface $expiresAt = null): string
    {
        $expirationInfo = '';
        if ($expiresAt) {
            $expirationTime = $expiresAt->format('H:i');
            $expirationInfo = "<p style=\"color: #666;\">Ce code expirera à $expirationTime.</p>";
        }

        return <<<HTML
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eaeaea; border-radius: 5px;">
            <div style="text-align: center; padding-bottom: 20px;">
                <h1 style="color: #333;">Réinitialisation de mot de passe</h1>
            </div>
            <div style="padding: 20px; background-color: #f9f9f9; border-radius: 4px;">
                <p>Bonjour,</p>
                <p>Vous avez demandé la réinitialisation de votre mot de passe pour votre compte EventCraft.</p>
                <p>Voici votre code de vérification :</p>
                <div style="text-align: center; margin: 30px 0;">
                    <div style="font-size: 32px; letter-spacing: 5px; font-weight: bold; background-color: #eee; padding: 10px; border-radius: 4px;">$verificationCode</div>
                </div>
                <p>Entrez ce code sur la page de vérification pour continuer le processus de réinitialisation de votre mot de passe.</p>
                $expirationInfo
                <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer cet email.</p>
            </div>
            <div style="text-align: center; margin-top: 20px; color: #888; font-size: 12px;">
                <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
                <p>&copy; EventCraft</p>
            </div>
        </div>
        HTML;
    }

    /**
     * Send a test email
     * 
     * @param string $toEmail The recipient's email address
     * @return bool Whether the email was sent successfully
     */
    public function sendTestEmail(string $toEmail): bool
    {
        try {
            $email = (new Email())
                ->from(new Address($this->senderEmail, $this->senderName))
                ->to($toEmail)
                ->subject('Test Email from EventCraft')
                ->html('<p>This is a test email from EventCraft. If you receive this, email sending is working correctly.</p>');

            $this->mailer->send($email);
            
            $this->logger->info('Test email sent successfully to: ' . $toEmail);
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Failed to send test email: ' . $e->getMessage(), [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }
}