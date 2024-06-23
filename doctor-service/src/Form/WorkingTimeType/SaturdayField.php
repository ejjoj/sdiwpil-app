<?php

namespace App\Form\WorkingTimeType;

class SaturdayField extends AbstractDayField
{
    protected function getFieldName(): string
    {
        return 'saturday';
    }
}
