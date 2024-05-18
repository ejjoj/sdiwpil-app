<?php

namespace App\Form;

use App\Service\Form\UserType\EmailField;
use App\Service\Form\UserType\PasswordField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

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
}
