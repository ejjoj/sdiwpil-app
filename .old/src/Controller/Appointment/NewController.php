<?php

namespace App\Controller\Appointment;

use App\Service\Appointment\AppointmentNewActionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    /**
     * @Route(
     *     "/appointment/new",
     *     name="front.appointment.new",
     *     methods={"POST"},
     * )
     * @param AppointmentNewActionService $actionService
     * @return JsonResponse
     */
    public function index(AppointmentNewActionService $actionService): JsonResponse
    {
        return $actionService->getJsonResponse();
    }
}
