<?php

namespace App\Validator;

use DateTime;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WorkingDayValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint WorkingDay */
        if (!$constraint instanceof WorkingDay) {
            throw new UnexpectedTypeException($constraint, WorkingDay::class);
        }

        $start = $value['start'] ?? null;
        $end = $value['end'] ?? null;
        if (!$start && !$end) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        if (!$this->isValidWorkingDay($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->getInvalidValue($value))
                ->addViolation();
        }
    }

    private function isValidWorkingDay(array $workingDay): bool
    {
        $start = $workingDay['start'] ?? null;
        $end = $workingDay['end'] ?? null;

        if (($start && !$end) || (!$start && $end)) {
            return false;
        }

        return $end > $start;
    }

    private function getInvalidValue($value): string
    {
        return sprintf(
            '%s i %s',
            $this->getInvalidPartialValue($value, 'start'),
            $this->getInvalidPartialValue($value, 'end')
        );
    }

    private function getInvalidPartialValue($value, $key): string
    {
        $emptyResult = 'brak godziny oraz minuty';
        $format = 'H:i';
        /** @var DateTime $partialValue */
        $partialValue = $value[$key] ?? null;

        return $partialValue ? $partialValue->format($format) : $emptyResult;
    }
}
