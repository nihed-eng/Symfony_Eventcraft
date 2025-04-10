<?php

namespace App\Command;

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
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Send a test email');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
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