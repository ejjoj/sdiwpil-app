<?php

namespace App\Service\Validator\ViolationBuilder;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

abstract class AbstractViolationBuilder
{
    protected ExecutionContextInterface $context;
    protected mixed $value;
    protected Constraint $constraint;

    abstract protected function getMessage(): string;

    public function withContext(ExecutionContextInterface $context): static
    {
        $new = clone $this;
        $new->context = $context;

        return $new;
    }

    public function withValue(mixed $value): static
    {
        $new = clone $this;
        $new->value = $value;

        return $new;
    }

    public function withConstraint(Constraint $constraint): static
    {
        $new = clone $this;
        $new->constraint = $constraint;

        return $new;
    }

    public function build(): void
    {
        $this->context->buildViolation($this->getMessage())
            ->setParameter('{{ value }}', $this->value)
            ->addViolation();
    }
}
