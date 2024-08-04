<?php

namespace App\Service\Entity\PatientProfile\Flyweight;

use App\Entity\PatientProfile;
use App\Service\Entity\PatientProfile\Repository\FindByPeselPatientRepository;

class PeselPatientProfileFlyweight extends AbstractPatientProfileFlyweight
{
    private string $pesel;

    public function __construct(FindByPeselPatientRepository $patientProfileRepository)
    {
        parent::__construct($patientProfileRepository);
    }

    public function withPesel(string $pesel): static
    {
        $new = clone $this;
        $new->pesel = $pesel;

        return $new;
    }

    public function find(): ?PatientProfile
    {
        if (isset($this->profiles[$this->pesel])) {
            return $this->profiles[$this->pesel];
        }

        return $this->profiles[$this->pesel] = $this->patientProfileRepository
            ->withPesel($this->pesel)
            ->find();
    }
}
