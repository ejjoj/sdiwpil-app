<?php

namespace App\Model\Response\DoctorProfile\WorkingTime;

use App\Model\Response\ResponseDataModel;

class GetDataModel extends ResponseDataModel
{
    public function setWorkingTime(array $workingHours): static
    {
        $this->data['workingTime'] = $workingHours;

        return $this;
    }
}
