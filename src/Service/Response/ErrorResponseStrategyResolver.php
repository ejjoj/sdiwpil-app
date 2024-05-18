<?php

namespace App\Service\Response;

use App\Exception\BadRequestException;
use App\Service\Response\ErrorResponseResolver\AbstractResponseStrategy;
use App\Service\Response\ErrorResponseResolver\BadRequestErrorStrategy;
use App\Service\Response\ErrorResponseResolver\InternalServerErrorStrategy;

class ErrorResponseStrategyResolver
{
    private \Exception $exception;

    public function __construct(
        private readonly InternalServerErrorStrategy $internalServerErrorStrategy,
        private readonly BadRequestErrorStrategy $badRequestErrorStrategy,
    ) {
    }

    public function withException(\Exception $exception): static
    {
        $this->exception = $exception;

        return $this;
    }

    public function resolve(): AbstractResponseStrategy
    {
        try {
            throw $this->exception;
        } catch (BadRequestException $badRequestException) {
            return $this->badRequestErrorStrategy->withException($badRequestException);
        } catch (\Throwable $exception) {
            // Must remain as last catch block
            // TODO: consider Sentry
            return $this->internalServerErrorStrategy->withException($exception);
        }
    }
}
