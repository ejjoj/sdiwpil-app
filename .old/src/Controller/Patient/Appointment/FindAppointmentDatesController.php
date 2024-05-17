<?php

namespace App\Controller\Patient\Appointment;

use App\Service\Patient\FindAppointmentDatesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FindAppointmentDatesController extends AbstractController
{
    /**
     * @Route(
     *     "/patient/appointment/find-appointment-dates",
     *     name="front.patient.appointment.find_appointment_dates",
     *     methods={"POST"}
     * )
     * @param FindAppointmentDatesService $datesService
     * @return JsonResponse
     */
    public function index(FindAppointmentDatesService $datesService): JsonResponse
    {
        return $datesService->getJsonResponse();
    }
}
