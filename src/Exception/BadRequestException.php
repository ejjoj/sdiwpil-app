<?php

namespace App\Exception;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends \Exception
{
    private FormInterface $form;

    public function __construct(FormInterface $form, string $message = 'Invalid data')
    {
        parent::__construct($message, Response::HTTP_BAD_REQUEST);

        $this->form = $form;
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
