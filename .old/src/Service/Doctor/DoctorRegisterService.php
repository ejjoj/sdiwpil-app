<?php

namespace App\Service\Doctor;

use App\Controller\Doctor\Dashboard\ViewController;
use App\Controller\Doctor\Register\NewController;
use App\Entity\User;
use App\Form\Register\DoctorFormType;
use App\Service\AbstractRegisterService;

class DoctorRegisterService extends AbstractRegisterService
{
    protected function getRole(): string
    {
        return User::ROLE_DOCTOR;
    }

    protected function getRegisterNewRoute(): string
    {
        return NewController::ROUTE_NAME;
    }

    protected function getFormClass(): string
    {
        return DoctorFormType::class;
    }

    protected function getRedirectRouteName(): string
    {
        return ViewController::ROUTE_NAME;
    }
}
