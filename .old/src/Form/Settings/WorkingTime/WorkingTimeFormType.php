<?php

namespace App\Form\Settings\WorkingTime;

use App\Validator\WorkingDay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WorkingTimeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('monday', WorkingDayFormType::class, [
                'required' => true,
                'constraints' => [new WorkingDay()],
            ])
            ->add('tuesday', WorkingDayFormType::class, [
                'required' => true,
                'constraints' => [new WorkingDay()],
            ])
            ->add('wednesday', WorkingDayFormType::class, [
                'required' => true,
                'constraints' => [new WorkingDay()],
            ])
            ->add('thursday', WorkingDayFormType::class, [
                'required' => true,
                'constraints' => [new WorkingDay()],
            ])
            ->add('friday', WorkingDayFormType::class, [
                'required' => true,
                'constraints' => [new WorkingDay()],
            ])
            ->add('vacation', WorkingDayFormType::class, [
                'required' => true,
                'constraints' => [new WorkingDay()],
            ]);
    }
}
