<?php

namespace App\Service\Authorization;

use App\Model\Authorization\UserModel;

class UserBuilder
{
    public function build(object $userPayload): UserModel
    {
        return (new UserModel())
            ->setId($userPayload->id ?? null)
            ->setUsername($userPayload->username ?? null);
    }
}
