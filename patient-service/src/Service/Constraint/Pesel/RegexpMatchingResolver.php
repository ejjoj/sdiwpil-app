<?php

namespace App\Service\Constraint\Pesel;

class RegexpMatchingResolver
{
    public function resolve(string $pesel): bool
    {
        return preg_match('/^\d{11}$/', $pesel);
    }
}
