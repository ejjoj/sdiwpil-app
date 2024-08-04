<?php

namespace App\Validator;

use App\Service\Constraint\Pesel\ChecksumValidityResolver;
use App\Service\Constraint\Pesel\RegexpMatchingResolver;
use App\Service\Entity\PatientProfile\Flyweight\PeselPatientProfileFlyweight;
use App\Service\Validator\ViolationBuilder\ExistingValueViolationBuilder;
use App\Service\Validator\ViolationBuilder\InvalidValueViolationBuilder;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PeselValidator extends ConstraintValidator
{
    public function __construct(
        private readonly RegexpMatchingResolver $regexpMatchingResolver,
        private readonly ChecksumValidityResolver $checksumValidityResolver,
        private readonly PeselPatientProfileFlyweight $peselPatientProfileFlyweight,
        private readonly InvalidValueViolationBuilder $invalidValueViolationBuilder,
        private readonly ExistingValueViolationBuilder $existingValueViolationBuilder,
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
            !$this->regexpMatchingResolver->resolve($value)
            || !$this->checksumValidityResolver->resolve($value)
        ) {
            $this->buildInvalidValueViolation($value, $constraint);

            return;
        }

        if ($this->peselPatientProfileFlyweight->withPesel($value)->find()) {
            $this->buildPeselExistsViolation($value, $constraint);
        }
    }

    private function buildInvalidValueViolation(
        mixed $value,
        Pesel|Constraint $constraint
    ): void {
        $this->invalidValueViolationBuilder
            ->withValue($value)
            ->withContext($this->context)
            ->withConstraint($constraint)
            ->build();
    }

    private function buildPeselExistsViolation(
        mixed $value,
        Pesel|Constraint $constraint
    ): void {
        $this->existingValueViolationBuilder
            ->withValue($value)
            ->withContext($this->context)
            ->withConstraint($constraint)
            ->build();
    }
}
