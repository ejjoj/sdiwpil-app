<?php

namespace App\Service\Entity\User;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserConverter
{
    private array $payload;

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function withPayload(array $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    public function convert(): User
    {
        $email = $this->payload['email'] ?? '';
        $user = (new User())
            ->setEmail($email)
            ->setRoles([User::ROLE_USER])
            ->setUsername($email);
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $this->payload['plainPassword'] ?? '',
        );

        return $user->setPassword($hashedPassword);
    }
}
