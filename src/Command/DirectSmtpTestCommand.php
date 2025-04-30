<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\EmailService;

#[AsCommand(
    name: 'app:smtp-test',
    description: 'Test email sending using direct SMTP configuration'
)]
class DirectSmtpTestCommand extends Command
{
    private $emailService;

    public function __construct(EmailService $emailService)
    {
        parent::__construct();
        $this->emailService = $emailService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email address to send test to');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error('Invalid email address');
            return Command::FAILURE;
        }

        $io->section('Testing Direct SMTP Email');
        $io->text('Sending test email to: ' . $email);
        
        try {
            $code = sprintf('%06d', mt_rand(100000, 999999));
            $io->note('Generated verification code: ' . $code);
            
            // Test simple text email first
            $io->text('Step 1: Testing simple text email...');
            $result1 = $this->emailService->sendEmail(
                $email,
                'EventCraft SMTP Test - Simple Email',
                "This is a test email from EventCraft using direct SMTP configuration.\n\nTest code: $code"
            );
            
            if ($result1) {
                $io->success('Simple text email sent successfully!');
            } else {
                $io->error('Failed to send simple text email.');
                return Command::FAILURE;
            }
            
            // Test template email second
            $io->text('Step 2: Testing template email with verification code...');
            $result2 = $this->emailService->sendVerificationEmail(
                $email,
                $code,
                new \DateTimeImmutable('+1 hour')
            );
            
            if ($result2) {
                $io->success('Template email sent successfully!');
                $io->text([
                    'Both emails were sent successfully. Please:',
                    '1. Check your inbox for 2 test emails',
                    '2. Also check your spam/junk folder',
                    '3. Verification code for the template email: ' . $code
                ]);
                return Command::SUCCESS;
            } else {
                $io->error('Failed to send template email.');
                return Command::FAILURE;
            }
        } catch (\Exception $e) {
            $io->error([
                'Exception occurred: ' . $e->getMessage(),
                'Type: ' . get_class($e)
            ]);
            return Command::FAILURE;
        }
    }
}