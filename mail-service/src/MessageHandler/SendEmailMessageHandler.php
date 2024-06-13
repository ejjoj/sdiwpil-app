<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
final readonly class SendEmailMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private MailerInterface $mailer,
        private string $from,
    ) {
    }

    public function __invoke(SendEmailMessage $message): void
    {
        try {
            $this->sendEmail($message);
        } catch (\Throwable $e) {
            $this->logger->error('Error sending email', ['exception' => $e]);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendEmail(SendEmailMessage $message): void
    {
        $email = (new Email())
            ->from($this->from)
            ->to($message->getTo())
            ->subject($message->getSubject())
            ->text($message->getText());

        $this->mailer->send($email);
    }
}
