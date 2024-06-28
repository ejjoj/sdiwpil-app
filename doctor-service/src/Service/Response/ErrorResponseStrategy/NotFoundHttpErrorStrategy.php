<?php

namespace App\Service\Response\ErrorResponseStrategy;

use App\Model\Response\ResponseDataModel;
use App\Model\Response\ResponseModel;
use Symfony\Component\HttpFoundation\Response;

class NotFoundHttpErrorStrategy extends AbstractErrorResponseStrategy
{
    public function get(): ResponseModel
    {
        return (new ResponseModel())
            ->setStatusCode(Response::HTTP_NOT_FOUND)
            ->setResponseData($this->getResponseData());
    }

    private function getResponseData(): ResponseDataModel
    {
        return (new ResponseDataModel())
            ->setErrors([$this->exception->getMessage()]);
    }
}
