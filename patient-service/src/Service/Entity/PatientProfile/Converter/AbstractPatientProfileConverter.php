<?php

namespace App\Service\Entity\PatientProfile\Converter;

use App\Entity\PatientProfile;

abstract class AbstractPatientProfileConverter
{
    protected array $data;

    abstract public function convert(): PatientProfile;

    public function withData(array $data): static
    {
        $new = clone $this;
        $new->data = $data;

        return $new;
    }
}