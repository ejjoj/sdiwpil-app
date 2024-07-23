<?php

namespace App\Validator;

use App\Service\ExternalEntity\Flyweight\PatientProfileFlyweight;

class PatientProfileValidator extends AbstractProfileValidator
{
    public function __construct(PatientProfileFlyweight $flyweight)
    {
        parent::__construct($flyweight);
    }
}
