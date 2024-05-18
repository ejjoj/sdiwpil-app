<?php

namespace App\Service\Controller\Api\RegisterController;

use App\Exception\BadRequestException;
use App\Form\UserType;
use Symfony\Component\Form\FormFactoryInterface;

class DataValidator
{
    private array $data;

    public function __construct(
        private FormFactoryInterface $formFactory,
    )
    {
    }

    public function withData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @throws BadRequestException
     */
    public function validate(): void
    {
        $form = $this->formFactory
            ->create(UserType::class)
            ->submit($this->data);
        if (!$form->isValid()) {
            throw new BadRequestException((array) $form->getErrors(true, false));
        }
    }
}
