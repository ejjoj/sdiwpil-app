<?php

namespace App\Form\Appointment;

use App\Entity\Appointment;
use App\Entity\DoctorData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AppointmentNewFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('scheduledAt', DateTimeType::class, [
                'required' => true,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy-MM-dd HH:mm',
                'constraints' => [new NotBlank(null, 'Godzina wizyty musi być uzupełniona')],
            ])
            ->add('patientReason', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank(null, 'Powód wizyty musi być uzupełniony')],
            ])
            ->add('doctor', EntityType::class, [
                'required' => true,
                'class' => DoctorData::class,
                'constraints' => [new NotBlank(null, 'Lekarz musi być wybrany', false)],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
            'csrf_protection' => false,
        ]);
    }
}
