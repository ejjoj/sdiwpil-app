<?php

namespace App\Service\Validator\ViolationBuilder;

class ExistingValueViolationBuilder extends AbstractViolationBuilder
{
    protected function getMessage(): string
    {
        return $this->constraint->existsMessage;
    }
}
