<?php

namespace App\Service\Request;

readonly class TokenRepository
{
    public function __construct(private RequestExtractor $requestExtractor)
    {
    }

    public function find(): ?string
    {
        return $this->requestExtractor
            ->extract()
            ->headers
            ->get('authorization');
    }
}