<?php

namespace App\Service\Entity\Appointment\DayAvailabilityResolver;

use Carbon\Carbon;

interface DayAvailabilityResolverInterface
{
    public function isDayAvailable(
        array $daySchedule,
        Carbon $now,
        string $dayOfTheWeek,
        int $doctorProfileId
    ): bool;
}
