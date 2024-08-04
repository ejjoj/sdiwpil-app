<?php

namespace App\Service\Entity\PatientProfile\Converter;

use App\Entity\PatientProfile;

class FormToPatientProfileConverter extends AbstractPatientProfileConverter
{
    public function convert(): PatientProfile
    {
        return (new PatientProfile())
            ->setName($this->data['name'])
            ->setSecondName($this->data['secondName'] ?? null)
            ->setSurname($this->data['surname'])
            ->setGender($this->data['gender'])
            ->setPesel($this->data['pesel'])
            ->setBornAt(new \DateTimeImmutable($this->data['bornAt']->format('Y-m-d')))
            ->setCustomerId($this->data['customerId']);
    }
}