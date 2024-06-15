<?php

namespace App\Form;

use App\Entity\DoctorProfile;
use App\Entity\MedicalSpecialisation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // TODO: apply builder
        $builder
            ->add('name')
            ->add('secondName')
            ->add('surname')
            ->add('npwz')
            ->add('workingTime')
            ->add('customerId')
            ->add('medicalSpecialisation', EntityType::class, [
                'class' => MedicalSpecialisation::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DoctorProfile::class,
        ]);
    }
}
