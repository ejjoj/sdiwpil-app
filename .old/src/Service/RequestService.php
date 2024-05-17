<?php

namespace App\Service;

use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestService
{
    protected Request $request;

    public function __construct(private readonly RequestStack $requestStack)
    {
        $this->setRequest();
    }

    private function setRequest(): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            throw new RuntimeException(sprintf('Request must be an instance of "%s"', Request::class));
        }

        $this->request = $request;
    }
}
