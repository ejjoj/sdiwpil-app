<?php

namespace App\Service\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

readonly class RequestExtractor
{
    public function __construct(
        private RequestStack $requestStack,
    ) {
    }

    public function extract(): Request
    {
        if ($request = $this->requestStack->getCurrentRequest()) {
            return $request;
        }

        throw new \RuntimeException('Request not found');
    }
}
