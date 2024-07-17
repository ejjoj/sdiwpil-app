<?php

namespace App\Service\Entity\Appointment\DayAvailabilityResolver;

use Carbon\Carbon;

class DefaultDayAvailabilityResolver implements DayAvailabilityResolverInterface
{
    public function isDayAvailable(array $daySchedule, Carbon $date): bool
    {
        foreach ($daySchedule as $workingParts) {
            if (empty($workingParts['start']) || empty($workingParts['end'])) {
                continue;
            }

            $currentDayOfTheWeek = Carbon::now()->format('l');
            $start = Carbon::createFromFormat('H:i:s', $workingParts['start']);
            $end = Carbon::createFromFormat('H:i:s', $workingParts['end']);
            $currentDateHours = $date->format('H');
            $currentDateMinutes = $date->format('i');
            // TODO: somehting is wrong here...
            if (
                $date->format('l') === $currentDayOfTheWeek
                && $currentDateHours >= $start->format('H')
                && $currentDateHours <= $end->format('H')
                && $currentDateMinutes >= $start->format('i')
                && $currentDateMinutes <= $end->format('i')
            ) {
                return true;
            }
        }

        return false;
    }
}
