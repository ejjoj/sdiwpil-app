<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginatedRequestService
{
    private Request $request;

    public function __construct(private readonly RequestStack $requestStack)
    {
        $this->setRequest();
    }

    #[ArrayShape(['min' => "float|int", 'max' => "int"])] public function getMinMax(): array
    {
        $page = (int)$this->request->get('page', 1);
        $perPage = (int)$this->request->get('per_page', 25);

        return [
            'min' => $perPage * ($page - 1),
            'max' => $perPage,
        ];
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
