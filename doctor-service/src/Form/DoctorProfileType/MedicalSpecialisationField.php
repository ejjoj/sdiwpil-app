<?php

namespace App\Form\DoctorProfileType;

use App\Entity\MedicalSpecialisation;
use App\Form\AbstractFormField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MedicalSpecialisationField extends AbstractFormField
{
    protected function getFieldName(): string
    {
        return 'medicalSpecialisation';
    }

    protected function getFieldType(): ?string
    {
        return EntityType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'class' => MedicalSpecialisation::class,
            'choice_label' => 'id',
        ];
    }
}
