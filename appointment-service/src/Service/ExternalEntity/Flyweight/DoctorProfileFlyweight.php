<?php

namespace App\Service\ExternalEntity\Flyweight;


use App\Service\ExternalEntity\Repository\DoctorProfileRepository;

class DoctorProfileFlyweight extends AbstractFlyweight
{
    public function __construct(DoctorProfileRepository $repository)
    {
        parent::__construct($repository);
    }
}
