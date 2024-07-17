<?php

namespace App\Service;

trait WithDoctorProfileIdTrait
{
    protected int $doctorProfileId;

    public function withDoctorProfileId(int $doctorProfileId): static
    {
        $this->doctorProfileId = $doctorProfileId;

        return $this;
    }
}
