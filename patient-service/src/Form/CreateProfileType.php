<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\CreateProfileType\BornAtField\BornAtFieldFactory;
use App\Form\CreateProfileType\GenderField;
use App\Form\CreateProfileType\NameField\NameFieldFactory;
use App\Form\CreateProfileType\PeselField\PeselFieldFactory;
use App\Form\CreateProfileType\SecondNameField\SecondNameFieldFactory;
use App\Form\CreateProfileType\SurnameField\SurnameFieldFactory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CreateProfileType extends AbstractType
{
    public function __construct(
        private readonly NameFieldFactory $nameFieldFactory,
        private readonly SecondNameFieldFactory $secondNameFieldFactory,
        private readonly SurnameFieldFactory $surnameFieldFactory,
        private readonly BornAtFieldFactory $bornAtFieldFactory,
        private readonly PeselFieldFactory $peselFieldFactory,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $nameField = $this->nameFieldFactory->create();
        $nameField->setNextField($this->secondNameFieldFactory->create())
            ->setNextField($this->surnameFieldFactory->create())
            ->setNextField(new GenderField())
            ->setNextField($this->bornAtFieldFactory->create())
            ->setNextField($this->peselFieldFactory->create());
        $nameField->withBuilder($builder)
            ->build();
    }
}
