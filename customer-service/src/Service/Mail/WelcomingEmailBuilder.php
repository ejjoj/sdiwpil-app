<?php

namespace App\Service\Mail;

use App\Entity\User;
use App\Message\SendEmailMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class WelcomingEmailBuilder
{
    private User $user;

    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function withUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function build(): SendEmailMessage
    {
        return new SendEmailMessage(
            $this->user->getEmail(),
            $this->translator->trans('register.welcome.title', ['name' => $this->user->getUsername()]),
            $this->translator->trans('register.welcome.text')
        );
    }
}
