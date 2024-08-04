<?php

namespace App\Service\Entity\PatientProfile\Repository;

use App\Entity\PatientProfile;

readonly class FindByPeselPatientRepository extends AbstractPatientProfileRepository
{
    private string $pesel;

    public function withPesel(string $pesel): static
    {
        $new = clone $this;
        $new->pesel = $pesel;

        return $new;
    }

    public function find(): ?PatientProfile
    {
        return $this->patientProfileRepository->findOneBy(['pesel' => $this->pesel]);
    }
}
