<?php

namespace App\Form\Settings;

use App\Entity\MedicalSpecialty;
use App\Form\Settings\WorkingTime\WorkingTimeFormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

class DoctorSettingsFormType extends UserSettingsFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('medicalSpecialty', EntityType::class, [
                'required' => true,
                'class' => MedicalSpecialty::class
            ])
            ->add('workingTime', WorkingTimeFormType::class, [
                'required' => true,
            ]);
    }
}
