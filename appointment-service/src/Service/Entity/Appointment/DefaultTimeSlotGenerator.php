<?php

namespace App\Service\Entity\Appointment;

use App\Service\Entity\Appointment\DayAvailabilityResolver\DefaultDayAvailabilityResolver;
use Carbon\Carbon;

class DefaultTimeSlotGenerator
{
    private array $workingHours;

    public function __construct(
        private readonly DefaultDayAvailabilityResolver $defaultDayAvailabilityResolver
    ) {
    }

    public function withWorkingHours(array $workingHours): static
    {
        $this->workingHours = $workingHours;

        return $this;
    }

    public function generate(): array
    {
        $now = $this->roundUpTime();
        $oneMonthLater = Carbon::now()->addMonth();

        while ($now->lessThan($oneMonthLater)) {
//            $dayOfWeek = strtolower($now->format('l'));
            $dayOfWeek = 'monday'; // TODO: remove this line, uncomment the line above
            $daySchedule = $this->workingHours[$dayOfWeek] ?? [];
            if ($this->isDayAvailable($daySchedule, $now)) {
                $result[] = clone $now;
            }

            $now->addMinutes(30);
        }

        return $result ?? [];
    }

    private function roundUpTime(): Carbon
    {
        $now = Carbon::now();
        $minutes = (int) $now->format('i');
        $roundedMinutes = $minutes <= 30
            ? 30
            : 0;

        return Carbon::now()
            ->setMinute($roundedMinutes)
            ->setSecond(0);
    }

    private function isDayAvailable(array $daySchedule, Carbon $now): bool
    {
        return $this->defaultDayAvailabilityResolver->isDayAvailable(
            $daySchedule,
            $now
        );
    }
}
