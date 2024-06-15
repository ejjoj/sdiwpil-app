<?php

namespace App\Form\DoctorProfileType;

class SecondNameField extends AbstractNameField
{
    protected function getFieldName(): string
    {
        return 'secondName';
    }

    protected function getConstraints(): array
    {
        return [
            $this->getLengthConstraint(),
        ];
    }
}
