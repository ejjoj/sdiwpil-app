<?php

namespace App\Service\Entity\DoctorProfile;

use App\Entity\DoctorProfile;
use App\Service\Authorization\UserFlyweight;
use App\Service\Request\RequestExtractor;

readonly class DoctorProfileFetchingService
{
    public function __construct(
        private RequestExtractor $requestExtractor,
        private UserFlyweight $userFlyweight,
        private DoctorProfileFlyweight $doctorProfileFlyweight,
    ) {
    }

    public function get(): ?DoctorProfile
    {
        $token = $this->getToken();
        $customerId = $this->userFlyweight
            ->getUser($token)
            ?->getId();

        return $this->doctorProfileFlyweight->getDoctorProfile($customerId);
    }

    private function getToken(): ?string
    {
        return $this->requestExtractor
            ->extract()
            ->headers
            ->get('authorization');
    }
}
