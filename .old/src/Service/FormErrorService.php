<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;

class FormErrorService
{
    public function getArray(FormInterface $form): array
    {
        return $this->getErrors($form, $form->getName());
    }

    private function getErrors(FormInterface $baseForm, string $field): array
    {
        $errors = [];
        foreach ($baseForm->getErrors() as $error) {
            $errors[] = [
                'message' => $error->getMessage(),
                'field' => $field,
            ];
        }

        foreach ($baseForm->all() as $key => $child) {
            if (($child instanceof FormInterface)) {
                $cField = $child->getName();
                if ($field) {
                    $cField = $field . '_' . $cField;
                }

                $cErrors = $this->getErrors($child, $cField);
                $errors = array_merge($errors, $cErrors);
            }
        }

        return $errors;
    }
}
