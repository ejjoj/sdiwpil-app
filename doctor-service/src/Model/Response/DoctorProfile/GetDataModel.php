<?php

namespace App\Model\Response\DoctorProfile;

use App\Model\DoctorProfileModel;
use App\Model\Response\ResponseDataModel;

class GetDataModel extends ResponseDataModel
{
    public function setDoctorProfile(DoctorProfileModel $doctorProfileModel): static
    {
        $this->data['doctorProfile'] = $doctorProfileModel;

        return $this;
    }
}
