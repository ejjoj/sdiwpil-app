<?php

namespace App\Form\DoctorProfileType;

class SurnameField extends AbstractNameField
{

    protected function getFieldName(): string
    {
        return 'surname';
    }

    protected function getFieldOptions(): array
    {
        return [
            'required' => false,
        ];
    }
}
