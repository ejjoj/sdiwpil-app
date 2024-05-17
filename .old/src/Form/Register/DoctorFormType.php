<?php

namespace App\Form\Register;

use App\Entity\Clinic;
use App\Entity\MedicalSpecialty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

class DoctorFormType extends AbstractUserFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('medicalSpecialty', EntityType::class, [
                'required' => true,
                'class' => MedicalSpecialty::class
            ])
            ->add('clinic', EntityType::class, [
                'required' => true,
                'class' => Clinic::class,
            ]);
    }
}
