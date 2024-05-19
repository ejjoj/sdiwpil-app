<?php

namespace App\MessageHandler;

use App\Message\SendEmailMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
final class SendEmailMessageHandler
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer,
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
//            ->from($message->getFrom())
            ->to($message->getTo())
            ->subject($message->getSubject())
            ->text($message->getText());

        $this->mailer->send($email);
    }
}
