<?php

namespace App\Model\Authorization;

use App\Model\AbstractModel;

class UserModel extends AbstractModel
{
    public function setId(?int $id): static
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->data['id'] ?? null;
    }

    public function setUsername(?string $email): static
    {
        $this->data['username'] = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->data['username'] ?? null;
    }
}
