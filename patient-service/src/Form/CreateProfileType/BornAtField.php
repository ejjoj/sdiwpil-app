<?php

namespace App\Form\CreateProfileType;

use App\Form\AbstractFormField;
use App\Form\CreateProfileType\BornAtField\BornAtConstraintsFactory;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BornAtField extends AbstractFormField
{
    private BornAtConstraintsFactory $constraintsFactory;

    public function setConstraintsFactory(BornAtConstraintsFactory $constraintsFactory): static
    {
        $this->constraintsFactory = $constraintsFactory;

        return $this;
    }

    protected function getFieldName(): string
    {
        return 'bornAt';
    }

    protected function getFieldType(): ?string
    {
        return DateTimeType::class;
    }

    protected function getFieldOptions(): array
    {
        return [
            'html5' => false,
            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
            'constraints' => $this->constraintsFactory->create()->toArray(),
        ];
    }
}
