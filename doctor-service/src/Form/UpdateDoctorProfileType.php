<?php

namespace App\Form;

use App\Form\DoctorProfileType\MedicalSpecialisationField;
use App\Form\DoctorProfileType\NameField;
use App\Form\DoctorProfileType\SecondNameField;
use App\Form\DoctorProfileType\SurnameField;
use App\Form\DoctorProfileType\WorkingTimeField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateDoctorProfileType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $nameField = (new NameField())
            ->withBuilder($builder);
        $nameField->setNextField(new SecondNameField())
            ->setNextField(new SurnameField())
            ->setNextField(new WorkingTimeField())
            ->setNextField(new MedicalSpecialisationField());
        $nameField->build();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('csrf_protection', false);
    }
}
