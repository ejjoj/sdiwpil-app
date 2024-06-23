<?php

namespace App\Form\WorkingTimeType;

class SundayField extends AbstractDayField
{
    protected function getFieldName(): string
    {
        return 'sunday';
    }
}
