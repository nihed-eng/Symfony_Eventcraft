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
    name: 'app:javafx-email-test',
    description: 'Test email sending using JavaFX-style implementation',
)]
class JavaFxStyleEmailTestCommand extends Command
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

        $io->section('Testing JavaFX-style Email Implementation');
        $io->text('Sending test email to: ' . $email);
        
        try {
            $code = sprintf('%06d', mt_rand(100000, 999999));
            $io->note('Generated verification code: ' . $code);
            
            $io->text('Sending verification email...');
            $result = $this->emailService->sendVerificationEmail(
                $email, 
                $code
            );
            
            if ($result) {
                $io->success([
                    'Email sent successfully!',
                    'Verification code: ' . $code,
                    'Please check your inbox (including spam folder)'
                ]);
                return Command::SUCCESS;
            } else {
                $io->error('Failed to send email.');
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