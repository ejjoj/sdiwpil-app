<?php

namespace App\Form\CreateProfileType;

use App\Form\AbstractFormField;
use App\Form\CreateProfileType\NameField\NameFieldConstraintsFactory;
use Symfony\Component\Form\Extension\Core\Type\TextType;

abstract class AbstractNameField extends AbstractFormField
{
    private NameFieldConstraintsFactory $nameFieldConstraintsFactory;

    public function setNameFieldConstraintsFactory(
        NameFieldConstraintsFactory $nameFieldConstraintsFactory
    ): static {
        $this->nameFieldConstraintsFactory = $nameFieldConstraintsFactory;

        return $this;
    }

    protected function getFieldType(): ?string
    {
        return TextType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'constraints' => $this->nameFieldConstraintsFactory->create()->toArray(),
        ];
    }
}
