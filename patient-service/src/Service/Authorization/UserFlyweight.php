<?php

namespace App\Service\Authorization;

use App\Model\Authorization\UserModel;

class UserFlyweight
{
    private object $userPayload;

    private array $users;

    public function __construct(private readonly UserBuilder $userBuilder)
    {
    }

    public function withUserPayload(object $userPayload): static
    {
        $this->userPayload = $userPayload;

        return $this;
    }

    public function setUser(string $token): static
    {
        $this->users[$token] = $this->userBuilder->build($this->userPayload);

        return $this;
    }

    public function getUser(?string $token): ?UserModel
    {
        if (!$token) {
            return null;
        }

        return $this->users[$token] ?? null;
    }
}
