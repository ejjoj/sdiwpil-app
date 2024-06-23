<?php

namespace App\Form\WorkingTimeType;

use App\Form\AbstractFormField;
use App\Form\DayType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

abstract class AbstractDayField extends AbstractFormField
{
    protected function getFieldType(): ?string
    {
        return CollectionType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'entry_type' => DayType::class,
            'allow_add' => true,
            'allow_delete' => true,
        ];
    }
}
