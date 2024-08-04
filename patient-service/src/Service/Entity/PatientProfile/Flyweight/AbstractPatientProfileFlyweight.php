<?php

namespace App\Service\Entity\PatientProfile\Flyweight;

use App\Entity\PatientProfile;
use App\Service\Entity\PatientProfile\Repository\AbstractPatientProfileRepository;

abstract class AbstractPatientProfileFlyweight
{
    protected array $profiles = [];

    abstract public function find(): ?PatientProfile;

    public function __construct(protected AbstractPatientProfileRepository $patientProfileRepository)
    {
    }
}
