<?php

namespace App\Form;

use App\Form\CreateAppointmentType\DoctorProfileIdField;
use App\Form\CreateAppointmentType\PatientProfileIdField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateAppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $patientProfileIdField = new PatientProfileIdField();
        $patientProfileIdField->setNextField(new DoctorProfileIdField());
        $patientProfileIdField->withBuilder($builder)
            ->build();
    }
}
