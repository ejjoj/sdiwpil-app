<?php

namespace App\Service\Controller;

use App\Service\Request\RequestExtractor;

readonly class DependencyContainer
{
    public function __construct(
        private RequestExtractor $requestExtractor,
    ) {
    }

    public function getRequestExtractor(): RequestExtractor
    {
        return $this->requestExtractor;
    }
}
