<?php

namespace App\Form\Settings\WorkingTime;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;

class WorkingDayFormType extends AbstractType
{
    private const DATE_TIME_TYPE_OPTIONS = [
        'required' => true,
        'widget' => 'single_text',
        'html5' => false,
        'format' => 'HH:mm',
    ];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', DateTimeType::class, self::DATE_TIME_TYPE_OPTIONS)
            ->add('end', DateTimeType::class, self::DATE_TIME_TYPE_OPTIONS);
    }
}
