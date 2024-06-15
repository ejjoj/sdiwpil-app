<?php

namespace App\Service\Controller\Profile\Create;

use Symfony\Component\Form\FormFactoryInterface;

class DataValidator
{
    private array $data;

    public function __construct(
        private readonly FormFactoryInterface $formFactory,
    ) {
    }

    public function withData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function validate(): void
    {

    }
}
