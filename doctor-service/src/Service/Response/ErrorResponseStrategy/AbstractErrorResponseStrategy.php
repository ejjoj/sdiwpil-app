<?php

namespace App\Service\Response\ErrorResponseStrategy;

use App\Model\Response\ResponseModel;
use App\Service\Error\ErrorBuilder;
use App\Service\Response\ExceptionAwareInterface;
use App\Service\Response\WithExceptionTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

abstract class AbstractErrorResponseStrategy implements ExceptionAwareInterface
{
    use WithExceptionTrait;

    abstract public function get(): ResponseModel;

    public function __construct(
        protected readonly ErrorBuilder $errorBuilder,
        protected readonly TranslatorInterface $translator,
    ) {
    }
}
