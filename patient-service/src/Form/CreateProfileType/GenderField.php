<?php

namespace App\Form\CreateProfileType;

use App\Enum\Gender;
use App\Form\AbstractFormField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class GenderField extends AbstractFormField
{
    protected function getFieldName(): string
    {
        return 'gender';
    }

    protected function getFieldType(): ?string
    {
        return EnumType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'class' => Gender::class,
        ];
    }
}
