<?php

namespace App\Service\Patient;

use App\Entity\PatientData;
use DateTimeImmutable;
use Exception;
use RuntimeException;

class PeselDataHelper
{
    public function getGender(string $pesel): string
    {
        return (int)($pesel[9]) % 2 === 0 ? PatientData::GENDER_FEMALE : PatientData::GENDER_MALE;
    }

    /**
     * @throws Exception
     */
    public function getBornDate(string $pesel): DateTimeImmutable
    {
        $year = (int)substr($pesel, 0, 2);
        $month = substr($pesel, 2, 2);
        $day = (int)substr($pesel, 4, 2);
        $century = $this->getCentury($month);
        $month = $this->getCalculatedMonth($month, $century);

        $year += $century;
        $dateString = sprintf('%d-%d-%d', $year, $month, $day);

        return new DateTimeImmutable($dateString);
    }

    private function getCentury(string $month): int
    {
        $monthFirstPart = $month[0];
        switch ($month) {
            case ($monthFirstPart === '8' || $monthFirstPart === '9'):
                return 1800;
            case ($monthFirstPart === '0' || $monthFirstPart === '1'):
                return 1900;
            case ($monthFirstPart === '2' || $monthFirstPart === '3'):
                return 2000;
            case ($monthFirstPart === '4' || $monthFirstPart === '5'):
                return 2100;
            case ($monthFirstPart === '6' || $monthFirstPart === '7'):
                return 2200;
        }

        throw new RuntimeException('Unexpected month first part');
    }

    private function getCalculatedMonth(int $month, int $century): int
    {
        switch ($century) {
            case 1800:
                return $month - 80;
            case 1900:
                return $month;
            case 2000:
                return $month - 20;
            case 2100:
                return $month - 40;
            case 2200:
                return $month - 60;
        }

        throw new RuntimeException('Unexpected century');
    }
}
