<?php

namespace App\Form\CreateProfileType;

class SecondNameField extends AbstractNameField
{
    protected function getFieldName(): string
    {
        return 'secondName';
    }

    protected function getFieldOptions(): array
    {
        $fieldOptions = parent::getFieldOptions();
        $fieldOptions['required'] = false;

        return $fieldOptions;
    }
}
