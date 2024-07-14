<?php

namespace App\Service\Entity\DoctorProfile\WorkingHours;

use App\Entity\DoctorProfile;
use App\Model\Response\DoctorProfile\WorkingTime\GetDataModel;
use App\Model\Response\ResponseModel;
use Symfony\Component\HttpFoundation\Response;

class GetWorkingTimeResponseModelConverter
{
    private DoctorProfile $doctorProfile;

    public function withDoctorProfile(DoctorProfile $doctorProfile): static
    {
        $this->doctorProfile = $doctorProfile;

        return $this;
    }

    public function convert(): ResponseModel
    {
        return (new ResponseModel())
            ->setResponseData($this->getResponseData())
            ->setStatusCode(Response::HTTP_OK);
    }

    private function getResponseData(): GetDataModel
    {
        return (new GetDataModel())
            ->setWorkingTime($this->doctorProfile->getWorkingTime());
    }
}
