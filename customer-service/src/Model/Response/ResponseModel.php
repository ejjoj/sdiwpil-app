<?php

namespace App\Model\Response;

use App\Model\AbstractModel;

class ResponseModel extends AbstractModel
{
    public function setResponseData(ResponseDataModel $responseData): static
    {
        $this->data['responseData'] = $responseData;

        return $this;
    }

    public function getResponseData(): ResponseDataModel
    {
        return $this->data['responseData'] ?? new ResponseDataModel();
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->data['statusCode'] = $statusCode;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->data['statusCode'] ?? 0;
    }
}
