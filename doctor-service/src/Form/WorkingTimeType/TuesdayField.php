<?php

namespace App\Form\WorkingTimeType;

class TuesdayField extends AbstractDayField
{
    protected function getFieldName(): string
    {
        return 'tuesday';
    }
}
