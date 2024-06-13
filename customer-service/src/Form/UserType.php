<?php

namespace App\Form;

use App\Service\Form\UserType\EmailField;
use App\Service\Form\UserType\PasswordField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options,
    ): void {
        $emailField = (new EmailField())
            ->withBuilder($builder);
        $emailField->setNextField(new PasswordField());
        $emailField->build();
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('csrf_protection', false);
    }
}
