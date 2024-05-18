<?php

namespace App\Service\Form\UserType;

use App\Service\Form\AbstractFormField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordField extends AbstractFormField
{

    #[\Override] public function getFieldName(): string
    {
        return 'plainPassword';
    }

    #[\Override] public function getFieldType(): string
    {
        return PasswordType::class;
    }

    #[\Override] public function getFieldOptions(): array
    {
        return [
            'hash_property_path' => 'password',
            'mapped' => false,
        ];
    }
}
