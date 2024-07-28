<?php

namespace App\Form\CreateProfileType\PeselField;

use App\Validator\Pesel;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PeselConstraintsFactory
{
    public function create(): ArrayCollection
    {
        return new ArrayCollection([
            new NotBlank(),
            new Length(['min' => 11, 'max' => 11]),
            new Pesel(),
        ]);
    }
}
