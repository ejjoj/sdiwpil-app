<?php

namespace App\Service\ExternalEntity\Flyweight;

use App\Service\ExternalEntity\Repository\PatientProfileRepository;

class PatientProfileFlyweight extends AbstractFlyweight
{
    public function __construct(PatientProfileRepository $repository)
    {
        parent::__construct($repository);
    }
}
