<?php

namespace App\Service\Entity\DoctorProfile;

use App\Entity\DoctorProfile;
use App\Model\DoctorProfileModel;
use App\Model\MedicalSpecialisationModel;
use App\Service\Entity\MedicalSpecialisation\EntityToMedicalSpecialisationModelConverter;

class EntityToDoctorProfileModelConverter
{
    private DoctorProfile $doctorProfile;

    public function __construct(
        private readonly EntityToMedicalSpecialisationModelConverter $entityToMedicalSpecialisationModelConverter,
    ) {
    }

    public function withDoctorProfile(DoctorProfile $doctorProfile): static
    {
        $this->doctorProfile = $doctorProfile;

        return $this;
    }

    public function convert(): DoctorProfileModel
    {
        return (new DoctorProfileModel())
            ->setId($this->doctorProfile->getId())
            ->setName($this->doctorProfile->getName())
            ->setSecondName($this->doctorProfile->getSecondName())
            ->setSurname($this->doctorProfile->getSurname())
            ->setNpwz($this->doctorProfile->getNpwz())
            ->setWorkingTime($this->doctorProfile->getWorkingTime())
            ->setMedicalSpecialisation($this->getMedicalSpecialisation());
    }

    private function getMedicalSpecialisation(): MedicalSpecialisationModel
    {
        return $this->entityToMedicalSpecialisationModelConverter
            ->withMedicalSpecialisation($this->doctorProfile->getMedicalSpecialisation())
            ->convert();
    }
}
