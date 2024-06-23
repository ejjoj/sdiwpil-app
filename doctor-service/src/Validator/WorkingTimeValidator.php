<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class WorkingTimeValidator extends ConstraintValidator
{
    private WorkingTime $constraint;

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof WorkingTime) {
            return;
        }

        $this->constraint = $constraint;
        foreach ($value as $day => $periods) {
            $this->processPeriods($periods);
        }
    }

    private function processPeriods(array $periods): void
    {
        for ($i = 1; $i < count($periods); $i++) {
            $this->processRange($periods, $i);
        }
    }

    public function processRange(array $periods, int $i): void
    {
        $previousEnd = $periods[$i - 1]['end'];
        $currentStart = $periods[$i]['start'];
        $previousEndTime = \DateTime::createFromFormat('H:i:s', $previousEnd);
        $currentStartTime = \DateTime::createFromFormat('H:i:s', $currentStart);
        if ($previousEndTime < $currentStartTime) {
            return;
        }

        $this->context->buildViolation($this->constraint->message)
            ->setParameter('{{ end_time }}', $previousEnd)
            ->setParameter('{{ start_time }}', $currentStart)
            ->addViolation();
    }
}
