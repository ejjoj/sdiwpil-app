<?php

namespace App\Service\Response;

use App\Service\Response\ErrorResponseStrategy\AbstractErrorResponseStrategy;

class ErrorResponseStrategyResolver implements ExceptionAwareInterface
{
    use WithExceptionTrait;

    public function resolve(): AbstractErrorResponseStrategy
    {

    }
}
