<?php

namespace App\Form\DayType;

use App\Form\AbstractFormField;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractRangeField extends AbstractFormField
{
    protected function getFieldType(): ?string
    {
        return TimeType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => [new NotBlank()],
            'input' => 'string',
            'widget' => 'single_text',
        ];
    }
}
