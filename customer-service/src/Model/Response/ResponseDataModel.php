<?php

namespace App\Model\Response;

use App\Model\AbstractModel;
use App\Model\ErrorModel;

class ResponseDataModel extends AbstractModel
{
    /**
     * @param array<ErrorModel> $errors
     */
    public function setErrors(array $errors): static
    {
        $this->data['errors'] = $errors;

        return $this;
    }

    /**
     * @return array<ErrorModel>
     */
    public function getErrors(): array
    {
        return $this->data['errors'] ?? [];
    }

    public function setMessage(string $message): static
    {
        $this->data['message'] = $message;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->data['message'] ?? '';
    }
}
