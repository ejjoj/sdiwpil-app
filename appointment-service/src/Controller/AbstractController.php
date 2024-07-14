<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Controller\DependencyContainer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController extends SymfonyAbstractController
{
    public function __construct(
      private DependencyContainer $dependencyContainer,
    ) {
    }

    abstract public function __invoke(): JsonResponse;

    private function getRequest(): Request
    {
        return $this->dependencyContainer
            ->getRequestExtractor()
            ->extract();
    }
}
