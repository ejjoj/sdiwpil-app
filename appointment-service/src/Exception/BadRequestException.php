<?php

namespace App\Exception;

use Symfony\Component\Form\FormInterface;

class BadRequestException extends \Exception
{
    public function __construct(private readonly FormInterface $form)
    {
        parent::__construct();
    }

    public function getForm(): FormInterface
    {
        return $this->form;
    }
}
