<?php

namespace App\Service\Entity\Appointment;

use App\Service\Entity\Appointment\DayAvailabilityResolver\DefaultDayAvailabilityResolver;
use Carbon\Carbon;

class DefaultTimeSlotGenerator
{
    private array $workingHours;
    private int $doctorProfileId;

    public function __construct(
        private readonly DefaultDayAvailabilityResolver $defaultDayAvailabilityResolver
    ) {
    }

    public function withWorkingHours(array $workingHours): static
    {
        $this->workingHours = $workingHours;

        return $this;
    }

    public function withDoctorProfileId(int $doctorProfileId): static
    {
        $this->doctorProfileId = $doctorProfileId;

        return $this;
    }

    public function generate(): array
    {
        $now = $this->roundUpTime();
        $oneMonthLater = Carbon::now()->addMonth();

        while ($now->lessThan($oneMonthLater)) {
            $dayOfWeek = strtolower($now->format('l'));
            $daySchedule = $this->workingHours[$dayOfWeek] ?? [];
            if ($this->isDayAvailable($daySchedule, $now, $dayOfWeek)) {
                $result[] = $now->format('Y-m-d H:i:s');
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
        $roundedHours = $minutes <= 30
            ? (int) $now->format('H')
            : (int) $now->addHour()->format('H');

        return Carbon::now()
            ->setHour($roundedHours)
            ->setMinute($roundedMinutes)
            ->setSecond(0);
    }

    private function isDayAvailable(
        array $daySchedule,
        Carbon $now,
        string $dayOfTheWeek,
    ): bool {
        return $this->defaultDayAvailabilityResolver->isDayAvailable(
            $daySchedule,
            $now,
            $dayOfTheWeek,
            $this->doctorProfileId,
        );
    }
}
