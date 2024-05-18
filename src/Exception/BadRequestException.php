<?php

namespace App\Exception;

class BadRequestException extends \Exception
{
    private array $errors;

    public function __construct(array $errors, string $message = 'Invalid data')
    {
        parent::__construct($message, 400);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
