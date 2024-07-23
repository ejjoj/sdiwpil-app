<?php

namespace App\Validator;

use App\Service\ExternalEntity\Flyweight\AbstractFlyweight;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

abstract class AbstractProfileValidator extends ConstraintValidator
{
    public function __construct(private readonly AbstractFlyweight $flyweight)
    {
    }

    /**
     * @param AbstractProfileConstraint $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if ($this->flyweight->get($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
