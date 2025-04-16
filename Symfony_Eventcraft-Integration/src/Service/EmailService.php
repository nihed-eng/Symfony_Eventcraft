<?php

namespace App\Service;

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
} 