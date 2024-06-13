<?php

namespace App\Service\Error;

use App\Model\ErrorModel;

class ErrorBuilder
{
    private string $message;

    public function withMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function build(): ErrorModel
    {
        return (new ErrorModel())
            ->setMessage($this->message);
    }
}
