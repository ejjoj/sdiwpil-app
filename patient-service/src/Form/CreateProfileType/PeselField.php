<?php

namespace App\Form\CreateProfileType;

use App\Form\AbstractFormField;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PeselField extends AbstractFormField
{

    protected function getFieldName(): string
    {
        return 'pesel';
    }

    protected function getFieldType(): ?string
    {
        return TextType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => [],
        ];
    }
}
