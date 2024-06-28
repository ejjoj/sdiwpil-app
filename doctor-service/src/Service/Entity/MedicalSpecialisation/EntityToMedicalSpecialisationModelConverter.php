<?php

namespace App\Service\Entity\MedicalSpecialisation;

use App\Entity\MedicalSpecialisation;
use App\Model\MedicalSpecialisationModel;

class EntityToMedicalSpecialisationModelConverter
{
    private MedicalSpecialisation $medicalSpecialisation;

    public function withMedicalSpecialisation(MedicalSpecialisation $medicalSpecialisation): static
    {
        $this->medicalSpecialisation = $medicalSpecialisation;

        return $this;
    }

    public function convert(): MedicalSpecialisationModel
    {
        return (new MedicalSpecialisationModel())
            ->setId($this->medicalSpecialisation->getId())
            ->setTitle($this->medicalSpecialisation->getTitle());
    }
}
