<?php

namespace App\Form\CreateProfileType\PeselField;

use App\Form\CreateProfileType\PeselField;

readonly class PeselFieldFactory
{
    public function __construct(
        private PeselConstraintsFactory $peselConstraintsFactory
    ) {
    }

    public function create(): PeselField
    {
        return (new PeselField())
            ->setConstraintsFactory($this->peselConstraintsFactory);
    }
}
