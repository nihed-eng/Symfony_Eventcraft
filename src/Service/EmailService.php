<?php

namespace App\Service;

<<<<<<< HEAD
<<<<<<< HEAD
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailService
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host = 'smtp.gmail.com';
        $this->mailer->Port = 587;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = 'ayadi.baha35@gmail.com';
        $this->mailer->Password = 'pmib bgtr oeyg zpcz';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->CharSet = 'UTF-8';
        
        // Disable SSL verification (same as your JavaFX code)
        $this->mailer->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }

    public function sendVerificationEmail(string $toEmail, string $verificationCode): void
    {
        try {
            // Recipients
            $this->mailer->setFrom('ayadi.baha35@gmail.com', 'EventCraft');
            $this->mailer->addAddress($toEmail);

            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = 'Réinitialisation de votre mot de passe EventCraft';

            // HTML Email body
            $htmlBody = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #6366F1 0%, #EC4899 100%);
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .code {
            background-color: #F3F4F6;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            letter-spacing: 4px;
            color: #6366F1;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6B7280;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #6366F1 0%, #EC4899 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .warning {
            background-color: #FEF3F2;
            border: 1px solid #FCA5A5;
            color: #991B1B;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>EventCraft</h1>
            <p>Réinitialisation du mot de passe</p>
        </div>
        <div class="content">
            <h2>Bonjour,</h2>
            <p>Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte EventCraft. Voici votre code de vérification :</p>
            
            <div class="code">$verificationCode</div>
            
            <p><strong>Instructions :</strong></p>
            <ol>
                <li>Copiez le code ci-dessus</li>
                <li>Retournez sur la page de vérification</li>
                <li>Collez le code dans le champ prévu à cet effet</li>
            </ol>
            
            <p><strong>Important :</strong> Ce code expirera dans 30 minutes pour des raisons de sécurité.</p>
            
            <div class="warning">
                Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail en toute sécurité.
            </div>
        </div>
        <div class="footer">
            <p>Cet e-mail a été envoyé automatiquement, merci de ne pas y répondre.</p>
            <p>&copy; 2024 EventCraft. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
HTML;

            $this->mailer->Body = $htmlBody;
            
            // Plain text version for non-HTML mail clients
            $this->mailer->AltBody = "Votre code de vérification EventCraft est : $verificationCode\n\n" .
                                    "Ce code expirera dans 30 minutes.\n\n" .
                                    "Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet e-mail.";

            $this->mailer->send();
            error_log('Verification email sent successfully!');
        } catch (Exception $e) {
            error_log('Failed to send verification email: ' . $e->getMessage());
            error_log('Mailer Error: ' . $this->mailer->ErrorInfo);
            throw new \RuntimeException('Failed to send verification email: ' . $e->getMessage(), 0, $e);
        }
    }
=======
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mime\Address;
=======
<<<<<<< HEAD
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
>>>>>>> c139a4e (Résolution des conflits)

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
<<<<<<< HEAD
=======
>>>>>>> Salles
} 
=======
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
<<<<<<< HEAD
=======
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles

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
<<<<<<< HEAD
}
>>>>>>> 6ab9b1d (Initial commit)
=======
<<<<<<< HEAD
}
=======
}
>>>>>>> 6ab9b1d (Initial commit)
>>>>>>> c139a4e (Résolution des conflits)
>>>>>>> Salles
