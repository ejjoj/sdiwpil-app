<?php

namespace App\Form\CreateAppointmentType;

use App\Form\AbstractFormField;
use App\Validator\PatientProfile;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PatientProfileIdField extends AbstractFormField
{
    protected function getFieldName(): string
    {
        return 'patientProfileId';
    }

    protected function getFieldType(): ?string
    {
        return NumberType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => $this->getConstraints(),
        ];
    }

    private function getConstraints(): array
    {
        return [
            new PatientProfile(),
        ];
    }
}
