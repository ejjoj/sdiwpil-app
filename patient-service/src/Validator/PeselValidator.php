<?php

namespace App\Validator;

use App\Service\Constraint\Pesel\ChecksumValidityResolver;
use App\Service\Constraint\Pesel\RegexpMatchingResolver;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PeselValidator extends ConstraintValidator
{
    public function __construct(
        private readonly RegexpMatchingResolver $regexpMatchingResolver,
        private readonly ChecksumValidityResolver $checksumValidityResolver
    ) {
    }

    /**
     * @param Pesel $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (
            $this->regexpMatchingResolver->resolve($value)
            && $this->checksumValidityResolver->resolve($value)
            // TODO: add existing PESEL check
        ) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
