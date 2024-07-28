<?php

namespace App\Form\CreateProfileType\BornAtField;

use App\Form\CreateProfileType\BornAtField;

readonly class BornAtFieldFactory
{
    public function __construct(private BornAtConstraintsFactory $bornAtConstraintsFactory)
    {
    }

    public function create(): BornAtField
    {
        return (new BornAtField())
            ->setConstraintsFactory($this->bornAtConstraintsFactory);
    }
}
