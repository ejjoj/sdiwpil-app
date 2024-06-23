<?php

namespace App\Form\WorkingTimeType;

class FridayField extends AbstractDayField
{
    protected function getFieldName(): string
    {
        return 'friday';
    }
}
