<?php

namespace App\Form\CreateProfileType;

use App\Form\AbstractFormField;
use App\Form\CreateProfileType\PeselField\PeselConstraintsFactory;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PeselField extends AbstractFormField
{
    private PeselConstraintsFactory $constraintsFactory;

    public function setConstraintsFactory(PeselConstraintsFactory $constraintsFactory): static
    {
        $new = clone $this;
        $new->constraintsFactory = $constraintsFactory;

        return $new;
    }

    protected function getFieldName(): string
    {
        return 'pesel';
    }

    protected function getFieldType(): ?string
    {
        return TextType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => $this->constraintsFactory->create()->toArray(),
        ];
    }
}
