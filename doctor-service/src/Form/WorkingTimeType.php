<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\WorkingTimeType\FridayField;
use App\Form\WorkingTimeType\MondayField;
use App\Form\WorkingTimeType\SaturdayField;
use App\Form\WorkingTimeType\SundayField;
use App\Form\WorkingTimeType\ThursdayField;
use App\Form\WorkingTimeType\TuesdayField;
use App\Form\WorkingTimeType\WednesdayField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WorkingTimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $mondayField = (new MondayField())
            ->withBuilder($builder);
        $mondayField->setNextField(new TuesdayField())
            ->setNextField(new WednesdayField())
            ->setNextField(new ThursdayField())
            ->setNextField(new FridayField())
            ->setNextField(new SaturdayField())
            ->setNextField(new SundayField());
        $mondayField->build();
    }
}
