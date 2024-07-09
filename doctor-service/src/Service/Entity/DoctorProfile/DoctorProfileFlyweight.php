<?php

namespace App\Service\Entity\DoctorProfile;

use App\Entity\DoctorProfile;
use App\Repository\DoctorProfileRepository;

class DoctorProfileFlyweight
{
    private array $doctorProfiles = [];

    public function __construct(
        private readonly DoctorProfileRepository $doctorProfileRepository
    ) {
    }

    public function getDoctorProfile(int $customerId): ?DoctorProfile
    {
        if (isset($this->doctorProfiles[$customerId])) {
            return $this->doctorProfiles[$customerId];
        }

        return $this->doctorProfiles[$customerId] = $this->doctorProfileRepository->find($customerId);
    }
}
