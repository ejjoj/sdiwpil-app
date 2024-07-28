<?php

namespace App\Form\CreateProfileType\NameField;

use App\Form\CreateProfileType\AbstractNameField;
use App\Form\CreateProfileType\AbstractNameFieldFactory;
use App\Form\CreateProfileType\NameField;

readonly class NameFieldFactory extends AbstractNameFieldFactory
{
    protected function getInstance(): AbstractNameField
    {
        return new NameField();
    }
}
