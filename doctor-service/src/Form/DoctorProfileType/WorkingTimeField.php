<?php

namespace App\Form\DoctorProfileType;

use App\Form\AbstractFormField;
use App\Form\WorkingTimeType;
use App\Validator\WorkingTime;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkingTimeField extends AbstractFormField
{
    protected function getFieldName(): string
    {
        return 'workingTime';
    }

    protected function getFieldType(): ?string
    {
        return WorkingTimeType::class;
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
            new NotBlank(),
            new WorkingTime(),
        ];
    }
}
