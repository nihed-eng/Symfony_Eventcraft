<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Psr\Log\LoggerInterface;

class EmailService
{
    private LoggerInterface $logger;
    private string $senderEmail = 'ayadi.baha35@gmail.com';
    private string $appPassword = 'pmib bgtr oeyg zpcz'; // App password WITH spaces like in JavaFX

    public function __construct(LoggerInterface $logger) 
    {
        $this->logger = $logger;
    }

    /**
     * Send verification email with reset password code - implemented like JavaFX version
     * 
     * @param string $toEmail The recipient email
     * @param string $verificationCode The verification code
     * @param \DateTimeInterface|null $expiresAt When the code expires
     * 
     * @return bool Whether the email was sent successfully
     */
    public function sendVerificationEmail(string $toEmail, string $verificationCode, ?\DateTimeInterface $expiresAt = null): bool
    {
        // Create a new PHPMailer instance - equivalent to JavaFX MimeMessage
        $mail = new PHPMailer(true);

        try {
            // Configure SMTP settings - exactly like JavaFX Properties
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;

            // Authentication - equivalent to JavaFX PasswordAuthentication
            $mail->Username = $this->senderEmail;
            $mail->Password = $this->appPassword; // Using app password WITH spaces like in JavaFX
            
            // Set important email properties
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);

            // Sender and recipient - like JavaFX setFrom and setRecipients
            $mail->setFrom($this->senderEmail, 'EventCraft');
            $mail->addAddress($toEmail);

            // Subject
            $mail->Subject = 'Code de vérification - EventCraft';

            // Get HTML content from Twig template as a string
            // We're doing this manually as we're not using Symfony's mailer
            $html = $this->renderEmailTemplate('reset_password.html.twig', [
                'verification_code' => $verificationCode,
                'expires_at' => $expiresAt,
            ]);

            // Create plain text version (simplified)
            $plainText = "Réinitialisation de votre mot de passe EventCraft\n\n"
                . "Bonjour,\n\n"
                . "Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte EventCraft.\n"
                . "Votre code de vérification est: " . $verificationCode . "\n\n"
                . ($expiresAt ? "Ce code expirera le " . $expiresAt->format('d/m/Y à H:i') . ".\n\n" : "")
                . "Si vous n'avez pas demandé cette réinitialisation, vous pouvez ignorer cet email.\n\n"
                . "Cordialement,\n"
                . "L'équipe EventCraft";

            // Set content
            $mail->Body = $html;
            $mail->AltBody = $plainText;

            // Send the email - equivalent to JavaFX Transport.send
            $mail->send();
            
            $this->logger->info("Verification email sent successfully to {$toEmail}");
            return true;
        } catch (Exception $e) {
            $this->logger->error("Failed to send verification email: " . $mail->ErrorInfo, [
                'exception' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Send a simple text email
     */
    public function sendEmail(string $to, string $subject, string $message): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Configure SMTP settings
            $mail->isSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            
            // Set UTF-8 charset
            $mail->CharSet = 'UTF-8';

            // Authentication
            $mail->Username = $this->senderEmail;
            $mail->Password = $this->appPassword; // Using app password WITH spaces like in JavaFX

            // Sender and recipient
            $mail->setFrom($this->senderEmail, 'EventCraft');
            $mail->addAddress($to);

            // Email content
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send the email
            $mail->send();
            
            $this->logger->info("Email sent successfully to {$to}");
            return true;
        } catch (Exception $e) {
            $this->logger->error("Failed to send email: " . $mail->ErrorInfo, [
                'exception' => get_class($e)
            ]);
            return false;
        }
    }
    
    /**
     * Manually render a Twig template file as a string
     * 
     * This is a simple implementation since we're not using Symfony's Twig service
     */
    private function renderEmailTemplate(string $templateName, array $context = []): string
    {
        $templatePath = dirname(__DIR__, 2) . '/templates/emails/' . $templateName;
        
        if (!file_exists($templatePath)) {
            $this->logger->error("Email template not found: {$templateName}");
            // Fallback to basic HTML if template isn't found
            return "<html><body><p>Votre code de vérification est: <strong>{$context['verification_code']}</strong></p></body></html>";
        }
        
        $template = file_get_contents($templatePath);
        
        // Very basic template variable replacement - in a real app, use Twig service
        foreach ($context as $key => $value) {
            if ($key === 'expires_at' && $value instanceof \DateTimeInterface) {
                $formattedDate = $value->format('d/m/Y à H:i');
                $template = str_replace("{{ expires_at|date('d/m/Y à H:i') }}", $formattedDate, $template);
                // Also handle the if condition by removing the if/endif tags but keeping content
                $template = preg_replace('/\{% if expires_at %\}(.*?)\{% endif %\}/s', '$1', $template);
            } else {
                $template = str_replace("{{ {$key} }}", $value, $template);
            }
        }
        
        // Handle current year for copyright
        $template = str_replace("{{ \"now\"|date(\"Y\") }}", date('Y'), $template);
        
        return $template;
    }
}