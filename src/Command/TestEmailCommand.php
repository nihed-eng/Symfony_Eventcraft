<?php

namespace App\Command;

<<<<<<< HEAD
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class TestEmailCommand extends Command
{
    protected static $defaultName = 'app:test-email';

    public function __construct(private MailerInterface $mailer)
    {
=======
use App\Service\EmailService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:test-email',
    description: 'Send a test email to verify email configuration',
)]
class TestEmailCommand extends Command
{
    public function __construct(
        private EmailService $emailService
    ) {
>>>>>>> 6ab9b1d (Initial commit)
        parent::__construct();
    }

    protected function configure(): void
    {
<<<<<<< HEAD
        $this->setDescription('Send a test email');
=======
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email address to send test to')
            ->addArgument('code', InputArgument::OPTIONAL, 'Optional verification code to include in test (defaults to random code)');
>>>>>>> 6ab9b1d (Initial commit)
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
<<<<<<< HEAD
        try {
            $email = (new Email())
                ->from('ayadi.baha35@gmail.com')
                ->to('ayadi.baha35@gmail.com')
                ->subject('Test email from EventCraft')
                ->text('This is a test email to verify the email configuration.');

            $this->mailer->send($email);
            $output->writeln('Test email sent successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln('Error sending email: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
} 
=======
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $code = $input->getArgument('code') ?: sprintf('%06d', mt_rand(100000, 999999));

        $io->note("Attempting to send test email to: $email");

        // Test verification email
        $success = $this->emailService->sendVerificationEmail(
            $email,
            $code,
            new \DateTime('+1 hour')
        );

        if ($success) {
            $io->success("Verification email successfully sent to $email with code: $code");
            return Command::SUCCESS;
        } else {
            $io->error("Failed to send verification email to $email");
            $io->note("Please check your email configuration and server logs for more information.");
            return Command::FAILURE;
        }
    }
}
>>>>>>> 6ab9b1d (Initial commit)
