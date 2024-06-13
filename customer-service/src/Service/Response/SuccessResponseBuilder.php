<?php

namespace App\Service\Response;

use App\Model\Response\ResponseDataModel;
use App\Model\Response\ResponseModel;
use Symfony\Component\HttpFoundation\Response;

class SuccessResponseBuilder
{
    private string $message;

    public function withMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function build(): ResponseModel
    {
        return (new ResponseModel())
            ->setStatusCode(Response::HTTP_OK)
            ->setResponseData($this->getResponseData());
    }

    private function getResponseData(): ResponseDataModel
    {
        return (new ResponseDataModel())
            ->setMessage($this->message);
    }
}
