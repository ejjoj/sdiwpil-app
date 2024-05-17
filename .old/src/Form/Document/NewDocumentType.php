<?php

namespace App\Form\Document;

use App\Entity\DoctorData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

class NewDocumentType extends AbstractDocumentType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('doctor', EntityType::class, [
                'required' => true,
                'class' => DoctorData::class,
            ]);
    }
}
