<?php

namespace App\Service\Entity\DoctorProfile;

use App\Entity\DoctorProfile;

class FormToDoctorProfileConverter
{
    private array $data;
    private ?DoctorProfile $doctorProfile = null;

    public function withData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function withDoctorProfile(?DoctorProfile $doctorProfile): static
    {
        $this->doctorProfile = $doctorProfile;

        return $this;
    }

    public function convert(): DoctorProfile
    {
        $profile = $this->doctorProfile ?? new DoctorProfile();
        $this->setName($profile)
            ->setSecondName($profile)
            ->setSurname($profile)
            ->setCustomerId($profile)
            ->setNpwz($profile)
            ->setWorkingTime($profile)
            ->setMedicalSpecialisation($profile);

        return $profile;
    }

    private function setName(DoctorProfile $profile): static
    {
        if (!empty($this->data['name'])) {
            $profile->setName($this->data['name']);
        }

        return $this;
    }

    private function setSecondName(DoctorProfile $profile): static
    {
        if (!empty($this->data['secondName'])) {
            $profile->setSecondName($this->data['secondName']);
        }

        return $this;
    }

    private function setSurname(DoctorProfile $profile): static
    {
        if (!empty($this->data['surname'])) {
            $profile->setSurname($this->data['surname']);
        }

        return $this;
    }

    private function setCustomerId(DoctorProfile $profile): static
    {
        if (!empty($this->data['customerId'])) {
            $profile->setCustomerId($this->data['customerId']);
        }

        return $this;
    }

    private function setNpwz(DoctorProfile $profile): static
    {
        if (!empty($this->data['npwz'])) {
            $profile->setNpwz($this->data['npwz']);
        }

        return $this;
    }

    private function setWorkingTime(DoctorProfile $profile): static
    {
        if (!empty($this->data['workingTime'])) {
            $profile->setWorkingTime($this->data['workingTime']);
        }

        return $this;
    }

    private function setMedicalSpecialisation(DoctorProfile $profile): static
    {
        if (!empty($this->data['medicalSpecialisation'])) {
            $profile->setMedicalSpecialisation($this->data['medicalSpecialisation']);
        }

        return $this;
    }
}
