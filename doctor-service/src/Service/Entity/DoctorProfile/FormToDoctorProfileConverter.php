<?php

namespace App\Service\Entity\DoctorProfile;

use App\Entity\DoctorProfile;

class FormToDoctorProfileConverter
{
    public function convert(array $data): DoctorProfile
    {
        return (new DoctorProfile())
            ->setName($data['name'])
            ->setSecondName($data['secondName'] ?? null)
            ->setSurname($data['surname'])
            ->setCustomerId($data['customerId'])
            ->setNpwz($data['npwz'])
            ->setWorkingTime($data['workingTime'])
            ->setMedicalSpecialisation($data['medicalSpecialisation']);
    }
}
