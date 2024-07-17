<?php

namespace App\Model\Response\DoctorProfile\WorkingTime;

use App\Model\Response\ResponseDataModel;

class GetDataModel extends ResponseDataModel
{
    public function setWorkingHours(array $workingHours): static
    {
        $this->data['workingHours'] = $workingHours;

        return $this;
    }
}
