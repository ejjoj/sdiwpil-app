<?php

namespace App\Service\Response;

use App\Exception\BadRequestException;
use App\Service\Response\ErrorResponseStrategy\AbstractErrorResponseStrategy;
use App\Service\Response\ErrorResponseStrategy\BadRequestErrorStrategy;
use App\Service\Response\ErrorResponseStrategy\InternalServerErrorStrategy;
use function Sentry\captureException;

class ErrorResponseStrategyResolver implements ExceptionAwareInterface
{
    use WithExceptionTrait;

    public function __construct(
        private readonly InternalServerErrorStrategy $internalServerErrorStrategy,
        private readonly BadRequestErrorStrategy $badRequestErrorStrategy,
    ) {
    }

    public function resolve(): AbstractErrorResponseStrategy
    {
        try {
            throw $this->exception;
        } catch (BadRequestException $badRequestException) {
            return $this->badRequestErrorStrategy->withException($badRequestException);
        } catch (\Throwable $exception) {
            captureException($exception);

            return $this->internalServerErrorStrategy->withException($exception);
        }
    }
}
