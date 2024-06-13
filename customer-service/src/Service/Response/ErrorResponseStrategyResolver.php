<?php

namespace App\Service\Response;

use App\Exception\BadRequestException;
use App\Service\Response\ErrorResponseResolver\AbstractResponseStrategy;
use App\Service\Response\ErrorResponseResolver\BadRequestErrorStrategy;
use App\Service\Response\ErrorResponseResolver\InternalServerErrorStrategy;
use App\Service\Response\ErrorResponseResolver\UserAlreadyExistsErrorStrategy;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Psr\Log\LoggerInterface;
use function Sentry\captureException;

class ErrorResponseStrategyResolver
{
    private \Exception $exception;

    public function __construct(
        private readonly InternalServerErrorStrategy $internalServerErrorStrategy,
        private readonly BadRequestErrorStrategy $badRequestErrorStrategy,
        private readonly UserAlreadyExistsErrorStrategy $userAlreadyExistsErrorStrategy,
        private readonly LoggerInterface $logger,
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
        } catch (UniqueConstraintViolationException $constraintViolationException) {
            return $this->userAlreadyExistsErrorStrategy->withException($constraintViolationException);
        } catch (\Throwable $exception) {
            // Must remain as last catch block
            $this->captureException($exception);

            return $this->internalServerErrorStrategy->withException($exception);
        }
    }

    private function captureException(\Throwable|\Exception $exception): void
    {
        captureException($exception);
        $this->logger->error($exception->getMessage(), ['exception' => $exception]);
    }
}
