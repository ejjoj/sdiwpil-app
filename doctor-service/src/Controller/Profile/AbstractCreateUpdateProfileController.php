<?php

namespace App\Controller\Profile;

abstract class AbstractCreateUpdateProfileController extends AbstractProfileController
{
    protected function getCustomerId(): ?int
    {
        return $this->dependencyContainer
            ->getUserFlyweight()
            ->getUser($this->getToken())
            ?->getId();
    }

    private function getToken(): string
    {
        return $this->getRequest()
            ->headers
            ->get('authorization');
    }
}
