<?php

namespace App\Form\Message;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageBulkType extends AbstractType
{
    public const MESSAGES = 'messages';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::MESSAGES, CollectionType::class, [
                'required' => true,
                'entry_type' => MessageType::class,
                'allow_add' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('csrf_protection', false);
    }
}
