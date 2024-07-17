<?php

namespace App\Service\Model\GetAppointmentDates;

use App\Model\Response\GetAppointmentDates\GetAppointmentDatesResponseDataModel;
use App\Model\Response\ResponseModel;
use App\Service\WithDoctorProfileIdTrait;
use Symfony\Component\HttpFoundation\Response;

class SuccessfulResponseBuilder
{
    use WithDoctorProfileIdTrait;

    public function __construct(
        private readonly GetAppointmentDatesResponseDataModelBuilder $responseDataBuilder
    ) {
    }

    public function build(): ResponseModel
    {
        return (new ResponseModel())
            ->setResponseData($this->getBuild())
            ->setStatusCode(Response::HTTP_OK);
    }

    public function getBuild(): GetAppointmentDatesResponseDataModel
    {
        return $this->responseDataBuilder
            ->withDoctorProfileId($this->doctorProfileId)
            ->build();
    }
}
