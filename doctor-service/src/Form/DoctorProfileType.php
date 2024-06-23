<?php

namespace App\Form;

use App\Form\DoctorProfileType\CustomerIdField;
use App\Form\DoctorProfileType\MedicalSpecialisationField;
use App\Form\DoctorProfileType\NameField;
use App\Form\DoctorProfileType\NpwzField;
use App\Form\DoctorProfileType\SecondNameField;
use App\Form\DoctorProfileType\SurnameField;
use App\Form\DoctorProfileType\WorkingTimeField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DoctorProfileType extends AbstractType
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $nameField = (new NameField())
            ->withBuilder($builder);
        $nameField->setNextField(new SecondNameField())
            ->setNextField(new SurnameField())
            ->setNextField(new NpwzField($this->entityManager, $this->translator))
            ->setNextField(new WorkingTimeField())
            ->setNextField(new CustomerIdField($this->entityManager, $this->translator))
            ->setNextField(new MedicalSpecialisationField());
        $nameField->build();
    }
}
