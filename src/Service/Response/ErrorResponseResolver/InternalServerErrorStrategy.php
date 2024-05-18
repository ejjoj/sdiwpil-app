<?php

namespace App\Service\Response\ErrorResponseResolver;

use App\Model\Response\ResponseDataModel;
use App\Model\Response\ResponseModel;
use Symfony\Component\HttpFoundation\Response;

class InternalServerErrorStrategy extends AbstractResponseStrategy
{
    #[\Override]
    public function get(): ResponseModel
    {
        return (new ResponseModel())
            ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)
            ->setResponseData($this->getResponseData());
    }

    public function getResponseData(): ResponseDataModel
    {
        return (new ResponseDataModel())
            ->setErrors($this->getErrors());
    }

    private function getErrors(): array
    {
        $error = $this->errorBuilder
            ->withMessage($this->translator->trans('error.500'))
            ->build();

        return [$error];
    }
}
