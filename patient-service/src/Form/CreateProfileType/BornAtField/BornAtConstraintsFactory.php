<?php

namespace App\Form\CreateProfileType\BornAtField;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\NotBlank;

class BornAtConstraintsFactory
{
    public function create(): ArrayCollection
    {
        return new ArrayCollection([
            new NotBlank(),
        ]);
    }
}
