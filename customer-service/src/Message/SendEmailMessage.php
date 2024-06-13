<?php

namespace App\Message;

final readonly class SendEmailMessage
{
    public function __construct(
        private string $to,
        private string $subject,
        private string $text

    ) {
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
