<?php

namespace App\Model;

class DoctorProfileModel extends AbstractModel
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

    public function setName(string $name): static
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function setSecondName(?string $secondName): static
    {
        $this->data['secondName'] = $secondName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->data['secondName'];
    }

    public function setSurname(string $surname): static
    {
        $this->data['surname'] = $surname;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->data['surname'];
    }

    public function setNpwz(string $npwz): static
    {
        $this->data['npwz'] = $npwz;

        return $this;
    }

    public function getNpwz(): string
    {
        return $this->data['npwz'];
    }

    public function setWorkingTime(array $workingTime): static
    {
        $this->data['workingTime'] = $workingTime;

        return $this;
    }

    public function getWorkingTime(): array
    {
        return $this->data['workingTime'];
    }

    public function setMedicalSpecialisation(MedicalSpecialisationModel $medicalSpecialisationModel): static
    {
        $this->data['medicalSpecialisation'] = $medicalSpecialisationModel;

        return $this;
    }

    public function getMedicalSpecialisation(): MedicalSpecialisationModel
    {
        return $this->data['medicalSpecialisation'];
    }

    public function setCustomerId(int $customerId): static
    {
        $this->data['customerId'] = $customerId;

        return $this;
    }

    public function getCustomerId(): int
    {
        return $this->data['customerId'];
    }
}
