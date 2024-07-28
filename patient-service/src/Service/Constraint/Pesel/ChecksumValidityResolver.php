<?php

namespace App\Service\Constraint\Pesel;

class ChecksumValidityResolver
{
    private const array POSITION_WAGES = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];

    public function resolve(string $pesel): bool
    {
        $int = 10 - $this->getCheckSum($pesel) % 10;
        $controlSum = ($int === 10) ? 0 : $int;

        return $controlSum === (int)$pesel[10];
    }

    private function getCheckSum(string $pesel): int
    {
        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $sum += self::POSITION_WAGES[$i] * (int)$pesel[$i];
        }

        return $sum;
    }
}
