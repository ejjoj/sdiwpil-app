<?php

namespace App\Service\Appointment;

use App\Entity\Appointment;
use App\Entity\DoctorData;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;

class AppointmentDatesService
{
    private const TEXTUAL_DAY_REPRESENTATION_FORMAT = 'l';

    private DoctorData $doctorData;

    private array $result = [];

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function getResult(DoctorData $doctorData): array
    {
        $this->doctorData = $doctorData;
        $this->setAppointmentDatesForCurrentDay($doctorData->getWorkingTime() ?? []);

        return $this->result;
    }

    private function isVacationLeave(array $workingTime, Carbon $now): bool
    {
        $start = $workingTime['vacation']['start'] ?? null;
        $end = $workingTime['vacation']['end'] ?? null;
        if (!$start || !$end) {
            return false;
        }

        return $now->greaterThanOrEqualTo($start) && $now->lessThanOrEqualTo($end);
    }

    private function isBookedAppointment(Carbon $now): ?Appointment
    {
        return $this->entityManager->getRepository(Appointment::class)
            ->findOneBy([
                'scheduledAt' => $now->toDateTimeImmutable(),
                'doctor' => $this->doctorData,
            ]);
    }

    private function getNow(): Carbon
    {
        $now = Carbon::now();
        $hour = (int)$now->format('H');
        $minute = (int)$now->format('i');
        if ($minute > 0 && $minute < 30) {
            $minute = 30;
        } elseif ($minute > 30) {
            $minute = 0;
            $hour++;
        }

        return Carbon::createFromTime($hour, $minute);
    }

    private function createDateFromNowAndDate(Carbon $now, DateTime $date): Carbon
    {
        return Carbon::create(
            $now->format('Y'),
            $now->format('m'),
            $now->format('d'),
            $date->format('H'),
            $date->format('i')
        );
    }

    /**
     * @param array{now: Carbon, day: string, start: Carbon, end: Carbon} $params
     * @return bool
     */
    private function cannotUse(array $params): bool
    {
        $now = $params['now'];

        return $now->lessThan($params['start']) ||
            $now->greaterThan($params['end']) ||
            $this->isBookedAppointment($now) ||
            $now->eq(Carbon::now());
    }

    #[ArrayShape(['text' => "string", 'value' => "string"])] private function buildFrontEndValue(Carbon $now): array
    {
        return [
            'text' => sprintf('%s na godz.: %s', $now->format('d.m.Y'), $now->format('H:i')),
            'value' => $now->format('Y-m-d H:i'),
        ];
    }

    private function processFindingAppointmentDates(Carbon $now, DateTime $start, DateTime $end): void
    {
        $start = $this->createDateFromNowAndDate($now, $start);
        $end = $this->createDateFromNowAndDate($now, $end);
        $cannotUseParams = [
            'now' => $now,
            'start' => $start,
            'end' => $end,
        ];
        if (!$this->cannotUse($cannotUseParams)) {
            $this->result[] = $this->buildFrontEndValue($now);
        }
    }

    private function isWorkingDayEmpty($dayValuesFromToday): bool
    {
        return !(($dayValuesFromToday['start'] ?? false) && ($dayValuesFromToday['end'] ?? false));
    }

    private function setAppointmentDatesForCurrentDay(array $workingTime): void
    {
        if (empty($workingTime)) {
            return;
        }

        for ($now = $this->getNow(); $now < Carbon::now()->addMonth(); $now->addMinutes(30)) {
            $textualRepresentationOfCurrentDay = strtolower($now->format(
                self::TEXTUAL_DAY_REPRESENTATION_FORMAT
            ));
            $dayValuesFromToday = $workingTime[$textualRepresentationOfCurrentDay] ?? [];
            if (!$this->isWorkingDayEmpty($dayValuesFromToday) && !$this->isVacationLeave($workingTime, $now)) {
                $start = $dayValuesFromToday['start'];
                $end = $dayValuesFromToday['end'];
                $this->processFindingAppointmentDates($now, $start, $end);
            }
        }
    }
}
