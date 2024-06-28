<?php

namespace App\Model;

class MedicalSpecialisationModel extends AbstractModel
{
    public function setId(int $id): static
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->data['id'];
    }

    public function setTitle(string $title): static
    {
        $this->data['title'] = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->data['title'];
    }
}
