<?php

namespace App\Form\DayType;

class EndField extends AbstractRangeField
{
    protected function getFieldName(): string
    {
        return 'end';
    }
}
