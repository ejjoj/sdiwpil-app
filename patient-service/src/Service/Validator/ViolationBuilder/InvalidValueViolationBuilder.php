<?php

namespace App\Service\Validator\ViolationBuilder;

class InvalidValueViolationBuilder extends AbstractViolationBuilder
{
    protected function getMessage(): string
    {
        return $this->constraint->message;
    }
}
