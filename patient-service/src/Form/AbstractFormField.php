<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

abstract class AbstractFormField
{
    protected ?AbstractFormField $nextField = null;

    protected FormBuilderInterface $builder;

    abstract protected function getFieldName(): string;
    abstract protected function getFieldType(): ?string;
    abstract protected function getFieldOptions(): array;

    public function setNextField(AbstractFormField $nextField): AbstractFormField
    {
        $this->nextField = $nextField;

        return $nextField;
    }

    public function withBuilder(FormBuilderInterface $builder): static
    {
        $this->builder = $builder;

        return $this;
    }

    public function build(): void
    {
        $this->builder->add(
            $this->getFieldName(),
            $this->getFieldType(),
            $this->getFieldOptions(),
        );

        $this->nextField
            ?->withBuilder($this->builder)
            ->build();
    }
}
