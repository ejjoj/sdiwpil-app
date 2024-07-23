<?php

namespace App\Service\Response;

use App\Exception\AccessDeniedException;
use App\Exception\BadRequestException;
use App\Service\Response\ErrorResponseStrategy\AbstractErrorResponseStrategy;
use App\Service\Response\ErrorResponseStrategy\AccessDeniedErrorResponseStrategy;
use App\Service\Response\ErrorResponseStrategy\BadRequestErrorStrategy;
use App\Service\Response\ErrorResponseStrategy\InternalServerErrorStrategy;
use App\Service\Response\ErrorResponseStrategy\NotFoundHttpErrorStrategy;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function Sentry\captureException;

class ErrorResponseStrategyResolver implements ExceptionAwareInterface
{
    use WithExceptionTrait;

    public function __construct(
        private readonly InternalServerErrorStrategy $internalServerErrorStrategy,
        private readonly BadRequestErrorStrategy $badRequestErrorStrategy,
        private readonly NotFoundHttpErrorStrategy $notFoundHttpErrorStrategy,
        private readonly AccessDeniedErrorResponseStrategy $accessDeniedErrorResponseStrategy,
    ) {
    }

    public function resolve(): AbstractErrorResponseStrategy
    {
        try {
            throw $this->exception;
        } catch (AccessDeniedException $accessDeniedException) {
            return $this->accessDeniedErrorResponseStrategy->withException($accessDeniedException);
        } catch (BadRequestException $badRequestException) {
            return $this->badRequestErrorStrategy->withException($badRequestException);
        } catch (NotFoundHttpException $badRequestException) {
            return $this->notFoundHttpErrorStrategy->withException($badRequestException);
        } catch (\Throwable $exception) {
            captureException($exception);

            return $this->internalServerErrorStrategy->withException($exception);
        }
    }
}
