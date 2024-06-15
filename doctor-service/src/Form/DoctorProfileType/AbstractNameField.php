<?php

namespace App\Form\DoctorProfileType;

use App\Form\AbstractFormField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

abstract class AbstractNameField extends AbstractFormField
{

    protected function getFieldType(): string
    {
        return TextType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => $this->getConstraints(),
        ];
    }

    protected function getConstraints(): array
    {
        return [
            new NotBlank(),
            $this->getLengthConstraint()
        ];
    }

    protected function getLengthConstraint(): Length
    {
        return new Length(['min' => 2, 'max' => 128]);
    }
}
