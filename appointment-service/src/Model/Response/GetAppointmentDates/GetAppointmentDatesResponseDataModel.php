<?php

namespace App\Model\Response\GetAppointmentDates;

use App\Model\Response\ResponseDataModel;

class GetAppointmentDatesResponseDataModel extends ResponseDataModel
{
    public function setDates(array $dates): static
    {
        $this->data['dates'] = $dates;

        return $this;
    }
}
