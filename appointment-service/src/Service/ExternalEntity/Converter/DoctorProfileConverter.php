<?php

namespace App\Service\ExternalEntity\Converter;

use App\Model\ExternalEntity\AbstractExternalEntityModel;
use App\Model\ExternalEntity\DoctorProfileModel;

class DoctorProfileConverter extends AbstractExternalEntityConverter
{
    public function convert(): AbstractExternalEntityModel
    {
        return (new DoctorProfileModel())
            ->setId($this->rawResponse['id'] ?? 0);
    }
}
