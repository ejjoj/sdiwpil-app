<?php

namespace App\Service\Entity\Appointment\DayAvailabilityResolver;

use App\Repository\AppointmentRepository;
use Carbon\Carbon;

readonly class DefaultDayAvailabilityResolver implements DayAvailabilityResolverInterface
{
    public function __construct(private AppointmentRepository $appointmentRepository)
    {
    }

    public function isDayAvailable(
        array $daySchedule,
        Carbon $now,
        string $dayOfTheWeek,
        int $doctorProfileId,
    ): bool {
        $currentDayOfWeek = strtolower($now->format('l'));

        if ($currentDayOfWeek !== $dayOfTheWeek) {
            return false;
        }

        foreach ($daySchedule as $workingParts) {
            if (empty($workingParts['start']) || empty($workingParts['end'])) {
                continue;
            }

            $currentYmd = $now->format('Y-m-d');
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $currentYmd . ' ' . $workingParts['start']);
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $currentYmd . ' ' . $workingParts['end']);

            if (
                $now->between($start, $end)
                && $this->isDoctorAvailable($doctorProfileId, $now)
            ) {
                return true;
            }
        }

        return false;
    }

    private function isDoctorAvailable(int $doctorProfileId, Carbon $now): bool
    {
        $criteria = [
            'doctorProfileId' => $doctorProfileId,
            'scheduledAt' => $now->toDateTimeImmutable(),
        ];

        return $this->appointmentRepository->findOneBy($criteria) === null;
    }
}
