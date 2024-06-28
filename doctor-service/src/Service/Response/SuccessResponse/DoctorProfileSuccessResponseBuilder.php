<?php

namespace App\Service\Response\SuccessResponse;

use App\Entity\DoctorProfile;
use App\Model\DoctorProfileModel;
use App\Model\Response\DoctorProfile\GetDataModel;
use App\Service\Entity\DoctorProfile\EntityToDoctorProfileModelConverter;

class DoctorProfileSuccessResponseBuilder extends AbstractSuccessResponseBuilder
{
    private DoctorProfile $doctorProfile;

    public function __construct(
        private readonly EntityToDoctorProfileModelConverter $entityToDoctorProfileModelConverter
    ) {
    }

    public function withDoctorProfile(DoctorProfile $doctorProfile): static
    {
        $this->doctorProfile = $doctorProfile;

        return $this;
    }

    protected function getResponseData(): GetDataModel
    {
        return (new GetDataModel())
            ->setDoctorProfile($this->getDoctorProfileModel())
            ->setMessage($this->message);
    }

    private function getDoctorProfileModel(): DoctorProfileModel
    {
        return $this->entityToDoctorProfileModelConverter
            ->withDoctorProfile($this->doctorProfile)
            ->convert();
    }
}
