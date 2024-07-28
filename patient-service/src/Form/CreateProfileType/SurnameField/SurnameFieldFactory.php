<?php

namespace App\Form\CreateProfileType\SurnameField;

use App\Form\CreateProfileType\AbstractNameField;
use App\Form\CreateProfileType\AbstractNameFieldFactory;
use App\Form\CreateProfileType\SurnameField;

readonly class SurnameFieldFactory extends AbstractNameFieldFactory
{
    protected function getInstance(): AbstractNameField
    {
        return new SurnameField();
    }
}
