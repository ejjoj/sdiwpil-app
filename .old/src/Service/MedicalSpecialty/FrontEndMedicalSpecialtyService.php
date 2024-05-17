<?php

namespace App\Service\MedicalSpecialty;

use App\Entity\MedicalSpecialty;
use App\Service\AbstractFrontEndCachableService;

class FrontEndMedicalSpecialtyService extends AbstractFrontEndCachableService
{
    protected function getCacheKey(): string
    {
        return 'medical_specialties';
    }

    protected function getEntityClass(): string
    {
        return MedicalSpecialty::class;
    }
}
