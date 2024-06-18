<?php

namespace App\Service\Authorization;

class TokenConverter
{
    public function convert(?string $token): ?string
    {
        if (!$token) {
            return '';
        }

        return str_replace('Bearer ', '', $token);
    }
}
