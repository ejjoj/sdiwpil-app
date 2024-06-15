<?php

namespace App\Form\DoctorProfileType;

class NameField extends AbstractNameField
{
    protected function getFieldName(): string
    {
        return 'name';
    }
}
