<?php

namespace App\Service\Clinic;

use App\Entity\Clinic;
use App\Service\AbstractFrontEndCachableService;

class FrontEndClinicService extends AbstractFrontEndCachableService
{
    protected function getCacheKey(): string
    {
        return 'clinics';
    }

    protected function getEntityClass(): string
    {
        return Clinic::class;
    }
}
