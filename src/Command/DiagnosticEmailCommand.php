<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[AsCommand(
    name: 'app:diagnostic-email',
    description: 'Diagnostic tool for email delivery issues',
)]
class DiagnosticEmailCommand extends Command
{
    private $mailer;
    private $params;

    public function __construct(MailerInterface $mailer, ParameterBagInterface $params)
    {
        parent::__construct();
        $this->mailer = $mailer;
        $this->params = $params;
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

        // Display environment information
        $io->section('Environment Information');
        $io->table(
            ['Setting', 'Value'],
            [
                ['APP_ENV', $this->params->get('kernel.environment')],
                ['MAILER_DSN', $_ENV['MAILER_DSN'] ?? 'Not defined in environment'],
            ]
        );
        
        // Check if Gmail transport is configured correctly
        if (strpos($_ENV['MAILER_DSN'] ?? '', 'gmail://') !== 0) {
            $io->warning('You are not using the Gmail transport. Consider using gmail:// for Gmail accounts.');
        }
        
        // Test with direct method
        $io->section('Testing direct email sending');
        
        try {
            $code = sprintf('%06d', mt_rand(100000, 999999));
            $io->note('Attempting to send a test email directly with verification code: ' . $code);
            
            $testEmail = (new Email())
                ->from('ayadi.baha35@gmail.com')
                ->to($email)
                ->subject('Test Email from EventCraft Diagnostic Tool')
                ->text("This is a test email sent from the EventCraft diagnostic tool.\n\nYour verification code is: $code\n\nIf you can see this, your email configuration is working!");
            
            $this->mailer->send($testEmail);
            
            $io->success('Email sent directly! Check your inbox (and spam folder).');
            
            // Provide some troubleshooting tips
            $io->section('Next Steps');
            $io->text([
                '1. Check your inbox AND spam/junk folder for the test email',
                '2. If email not received, verify Gmail settings:',
                '   - Confirm 2-factor authentication is enabled on your Google account',
                '   - Verify the app password was generated correctly',
                '   - Try regenerating a new app password',
                '3. Make sure your Gmail account doesn\'t have sending limits or restrictions'
            ]);
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error([
                'Exception occurred: ' . $e->getMessage(),
                'Exception type: ' . get_class($e)
            ]);
            
            // Provide more detailed debugging information
            $io->section('Debugging Information');
            $io->text([
                'Full exception details:',
                $e->getTraceAsString()
            ]);
            
            return Command::FAILURE;
        }
    }
}