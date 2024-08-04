<?php

namespace App\Service\Entity\PatientProfile\Repository;

use App\Entity\PatientProfile;
use App\Repository\PatientProfileRepository;

abstract readonly class AbstractPatientProfileRepository
{
    abstract public function find(): ?PatientProfile;

    public function __construct(protected PatientProfileRepository $patientProfileRepository)
    {
    }
}