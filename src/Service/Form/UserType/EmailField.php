<?php

namespace App\Service\Form\UserType;

use App\Service\Form\AbstractFormField;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmailField extends AbstractFormField
{
    #[\Override] public function getFieldName(): string
    {
        return 'email';
    }

    #[\Override] public function getFieldType(): string
    {
        return EmailType::class;
    }

    #[\Override] public function getFieldOptions(): array
    {
        return ['constraints' => [new NotBlank()]];
    }
}
