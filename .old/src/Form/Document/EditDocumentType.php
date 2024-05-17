<?php

namespace App\Form\Document;

use App\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

class EditDocumentType extends AbstractDocumentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('document', EntityType::class, [
                'required' => true,
                'class' => Document::class,
            ]);
    }
}
