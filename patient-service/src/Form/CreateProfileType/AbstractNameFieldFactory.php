<?php

namespace App\Form\CreateProfileType;

use App\Form\CreateProfileType\NameField\NameFieldConstraintsFactory;

abstract readonly class AbstractNameFieldFactory
{
    abstract protected function getInstance(): AbstractNameField;

    public function __construct(
        private NameFieldConstraintsFactory $nameFieldConstraintsFactory,
    ) {
    }

    public function create(): AbstractNameField
    {
        return $this->getInstance()
            ->setNameFieldConstraintsFactory($this->nameFieldConstraintsFactory);
    }
}
