<?php

namespace App\Validator;

use App\Service\ExternalEntity\Flyweight\DoctorProfileFlyweight;

class DoctorProfileValidator extends AbstractProfileValidator
{
    public function __construct(DoctorProfileFlyweight $flyweight)
    {
        parent::__construct($flyweight);
    }
}
