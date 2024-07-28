<?php

namespace App\Service\Constraint\Length;

use Symfony\Component\Validator\Constraints\Length;

class LengthNameConstraintFactory
{
    public function create(): Length
    {
        return new Length([
            'min' => 3,
            'max' => 128,
        ]);
    }
}
