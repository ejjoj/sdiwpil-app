<?php

namespace App\Form\CreateProfileType;

class SurnameField extends AbstractNameField
{
    protected function getFieldName(): string
    {
        return 'surname';
    }
}
