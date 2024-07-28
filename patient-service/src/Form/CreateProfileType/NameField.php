<?php

namespace App\Form\CreateProfileType;

class NameField extends AbstractNameField
{
    protected function getFieldName(): string
    {
        return 'name';
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => $this->nameFieldConstraintsFactory->create()->toArray(),
        ];
    }
}
