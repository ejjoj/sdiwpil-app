<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\DayType\EndField;
use App\Form\DayType\StartField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class DayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $startField = (new StartField())
            ->withBuilder($builder);
        $startField->setNextField(new EndField());
        $startField->build();
    }
}
