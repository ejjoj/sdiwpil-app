<?php

namespace App\Service\Response\ErrorResponseResolver;

use App\Model\Response\ResponseDataModel;
use App\Model\Response\ResponseModel;
use Symfony\Component\HttpFoundation\Response;

class UserAlreadyExistsErrorStrategy extends AbstractResponseStrategy
{
    #[\Override] public function get(): ResponseModel
    {
        return (new ResponseModel())
            ->setStatusCode(Response::HTTP_CONFLICT)
            ->setResponseData($this->getResponseData());
    }

    private function getResponseData(): ResponseDataModel
    {
        return (new ResponseDataModel())
            ->setErrors($this->getErrors());
    }

    private function getErrors(): array
    {
        $error = $this->errorBuilder
            ->withMessage($this->translator->trans('error.user_already_exists'))
            ->build();

        return [$error];
    }
}
