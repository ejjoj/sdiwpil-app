<?php

namespace App\Form\DayType;

class StartField extends AbstractRangeField
{
    protected function getFieldName(): string
    {
        return 'start';
    }
}
