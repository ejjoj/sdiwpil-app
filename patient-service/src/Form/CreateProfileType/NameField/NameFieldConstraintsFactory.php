<?php

namespace App\Form\CreateProfileType\NameField;

use App\Service\Constraint\Length\LengthNameConstraintFactory;
use Doctrine\Common\Collections\ArrayCollection;

readonly class NameFieldConstraintsFactory
{
    public function __construct(
        private LengthNameConstraintFactory $lengthNameConstraintFactory
    ) {
    }

    public function create(): ArrayCollection
    {
        return new ArrayCollection([
            $this->lengthNameConstraintFactory->create(),
        ]);
    }
}
