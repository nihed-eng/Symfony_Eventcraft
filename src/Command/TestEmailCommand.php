<?php

namespace App\Command;

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
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email address to send test to')
            ->addArgument('code', InputArgument::OPTIONAL, 'Optional verification code to include in test (defaults to random code)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
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