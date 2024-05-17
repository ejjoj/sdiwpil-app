<?php

namespace App\Form\Document;

use App\Entity\Document;
use App\Entity\PatientData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

abstract class AbstractDocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => Document::ALLOWED_TYPES,
            ])
            ->add('patient', EntityType::class, [
                'required' => true,
                'class' => PatientData::class
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $this->addFieldsBasedOnType($event);
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }

    private function addPrescriptionFields(FormInterface $form): void
    {
        $mapping = [
            'medicamentName' => 255,
            'medicamentDescription' => 255,
            'medicamentUsageDescription' => 255,
            'medicamentRemission' => 4,
        ];

        foreach ($mapping as $fieldName => $constraintLength) {
            $form->add($fieldName, TextType::class, [
                'required' => true,
                'constraints' => [new Length(null, null, $constraintLength)],
            ]);
        }
    }

    private function addFieldsBasedOnType(FormEvent $event): void
    {
        $type = $event->getData()['type'] ?? '';
        if ($type === Document::PRESCRIPTION_TYPE) {
            $this->addPrescriptionFields($event->getForm());
        }
    }
}
