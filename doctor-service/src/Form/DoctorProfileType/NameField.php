<?php

namespace App\Form\DoctorProfileType;

class NameField extends AbstractNameField
{
    protected function getFieldName(): string
    {
        return 'name';
    }

    protected function getFieldOptions(): array
    {
        return [
            'required' => false,
            'constraints' => $this->getConstraints(),
        ];
    }

    protected function getConstraints(): array
    {
        return [
            $this->getLengthConstraint(),
        ];
    }
}
