<?php

namespace App\Validator;

use App\Entity\PatientData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PeselValidator extends ConstraintValidator
{
    /**
     * @see https://cyberfolks.pl/blog/walidacja-pesel-w-php/
     */
    private const POSITION_WAGES = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        /* @var $constraint Pesel */

        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->isMatchingRegExp($value) || !$this->isCheckSumValid($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

        if ($this->isExistingPesel($value))  {
            $this->context->buildViolation('Podany numer PESEL jest już przypisany do użytkownika')
                ->addViolation();
        }
    }

    /**
     * @see https://cyberfolks.pl/blog/walidacja-pesel-w-php/
     */
    private function isMatchingRegExp(string $pesel): bool
    {
        return preg_match('/^\d{11}$/', $pesel);
    }

    private function getCheckSum(string $pesel): int
    {
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += self::POSITION_WAGES[$i] * (int)$pesel[$i];
        }

        return $sum;
    }

    /**
     * @see https://cyberfolks.pl/blog/walidacja-pesel-w-php/
     */
    private function isCheckSumValid(string $pesel): bool
    {
        $int = 10 - $this->getCheckSum($pesel) % 10;
        $controlSum = ($int === 10) ? 0 : $int;

        return $controlSum === (int)$pesel[10];
    }

    private function isExistingPesel(string $pesel): bool
    {
        return (bool)$this->entityManager->getRepository(PatientData::class)->findOneBy(['pesel' => $pesel]);
    }
}
