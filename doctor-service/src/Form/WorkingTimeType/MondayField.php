<?php

namespace App\Form\WorkingTimeType;

class MondayField extends AbstractDayField
{
    protected function getFieldName(): string
    {
        return 'monday';
    }
}
