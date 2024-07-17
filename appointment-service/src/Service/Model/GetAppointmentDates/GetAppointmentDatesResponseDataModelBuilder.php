<?php

namespace App\Service\Model\GetAppointmentDates;

use App\Model\Response\GetAppointmentDates\GetAppointmentDatesResponseDataModel;
use App\Service\Entity\Appointment\AppointmentDatesBuilder;
use App\Service\WithDoctorProfileIdTrait;

class GetAppointmentDatesResponseDataModelBuilder
{
    use WithDoctorProfileIdTrait;

    public function __construct(
        private readonly AppointmentDatesBuilder $appointmentDatesBuilder
    ) {
    }

    public function build(): GetAppointmentDatesResponseDataModel
    {
        return (new GetAppointmentDatesResponseDataModel())
            ->setDates($this->getDates());
    }

    private function getDates(): array
    {
        return $this->appointmentDatesBuilder
            ->withDoctorProfileId($this->doctorProfileId)
            ->build();
    }
}
