<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

abstract class AbstractProfileConstraint extends Constraint
{
    public string $message = 'The value "{{ value }}" is not valid.';
}
