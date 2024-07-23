<?php

namespace App\Model;

class ErrorModel extends AbstractModel
{
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
