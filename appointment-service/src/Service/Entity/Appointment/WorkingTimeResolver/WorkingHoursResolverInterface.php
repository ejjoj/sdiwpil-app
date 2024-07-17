<?php

namespace App\Service\Entity\Appointment\WorkingTimeResolver;

interface WorkingHoursResolverInterface
{
    public function resolve(int $doctorProfileId): array;
}
