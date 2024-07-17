<?php

namespace App\Service\Entity\Appointment;

use App\Service\Entity\Appointment\WorkingTimeResolver\DefaultWorkingHoursResolver;
use App\Service\WithDoctorProfileIdTrait;

class AppointmentDatesBuilder
{
    use WithDoctorProfileIdTrait;

    public function __construct(
        private readonly DefaultWorkingHoursResolver $workingHoursResolver,
        private readonly DefaultTimeSlotGenerator $timeSlotGenerator,
    ) {
    }

    public function build(): array
    {
        $workingHours = $this->workingHoursResolver->resolve($this->doctorProfileId);

        return $this->timeSlotGenerator
            ->withWorkingHours($workingHours)
            ->generate();
    }
}
