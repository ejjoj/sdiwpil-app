<?php

namespace App\Service\ExternalEntity\Converter;

use App\Model\ExternalEntity\AbstractExternalEntityModel;
use App\Model\ExternalEntity\PatientProfileModel;

class PatientProfileConverter extends AbstractExternalEntityConverter
{
    public function convert(): AbstractExternalEntityModel
    {
        return (new PatientProfileModel())
            ->setId($this->rawResponse['id'] ?? 0);
    }
}
