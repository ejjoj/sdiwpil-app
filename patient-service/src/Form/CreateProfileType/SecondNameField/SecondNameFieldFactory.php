<?php

namespace App\Form\CreateProfileType\SecondNameField;

use App\Form\CreateProfileType\AbstractNameField;
use App\Form\CreateProfileType\AbstractNameFieldFactory;
use App\Form\CreateProfileType\SecondNameField;

readonly class SecondNameFieldFactory extends AbstractNameFieldFactory
{
    protected function getInstance(): AbstractNameField
    {
        return new SecondNameField();
    }
}
