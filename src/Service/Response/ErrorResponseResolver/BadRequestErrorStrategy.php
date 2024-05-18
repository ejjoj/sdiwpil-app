<?php

namespace App\Service\Response\ErrorResponseResolver;

use App\Exception\BadRequestException;
use App\Model\Response\ResponseDataModel;
use App\Model\Response\ResponseModel;
use App\Service\Error\ErrorBuilder;
use App\Service\Form\ErrorsConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class BadRequestErrorStrategy extends AbstractResponseStrategy
{
    public function __construct(
        ErrorBuilder $errorBuilder,
        TranslatorInterface $translator,
        private readonly ErrorsConverter $errorsConverter,
    ) {
        parent::__construct($errorBuilder, $translator);
    }

    #[\Override]
    public function get(): ResponseModel
    {
        return (new ResponseModel())
            ->setStatusCode(Response::HTTP_BAD_REQUEST)
            ->setResponseData($this->getResponseData());
    }

    private function getResponseData(): ResponseDataModel
    {
        return (new ResponseDataModel())
            ->setErrors($this->getErrors());
    }

    private function getErrors(): array
    {
        /** @var BadRequestException $exception */
        $exception = $this->exception;

        return $this->errorsConverter
            ->withForm($exception->getForm())
            ->convert();
    }
}
