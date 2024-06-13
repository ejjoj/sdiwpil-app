<?php

namespace App\Service\Form;

use Symfony\Component\Form\FormInterface;

class ErrorsConverter
{
    private FormInterface $form;

    public function withForm(FormInterface $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function convert(): array
    {
        return $this->getErrors(
            $this->form,
            $this->form->getName(),
        );
    }

    private function getErrors(FormInterface $form, string $field): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $this->getError($error, $field);
        }

        foreach ($form->all() as $child) {
            if (!($child instanceof FormInterface)) {
                continue;
            }

            $childField = $child->getName();
            if ($field) {
                $childField = $field . '_' . $childField;
            }

            $childErrors = $this->getErrors($child, $childField);
            $errors = array_merge($errors, $childErrors);
        }

        return $errors;
    }

    public function getError($error, string $field): array
    {
        // TODO: move to model
        return [
            'message' => $error->getMessage(),
            'field' => $field,
        ];
    }
}
