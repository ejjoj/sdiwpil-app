<?php

namespace App\Form\Register;

use App\Validator\Pesel;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class PatientFormType extends AbstractUserFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('pesel', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Pesel(),
                ],
            ]);
    }
}
