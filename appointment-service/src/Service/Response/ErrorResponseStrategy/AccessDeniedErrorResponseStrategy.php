<?php

namespace App\Service\Response\ErrorResponseStrategy;

use App\Model\Response\ResponseDataModel;
use App\Model\Response\ResponseModel;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedErrorResponseStrategy extends AbstractErrorResponseStrategy
{
    public function get(): ResponseModel
    {
        return (new ResponseModel())
            ->setStatusCode(Response::HTTP_FORBIDDEN)
            ->setResponseData($this->getResponseData());
    }

    private function getResponseData(): ResponseDataModel
    {
        return (new ResponseDataModel())
            ->setErrors([$this->exception->getMessage()]);
    }
}
