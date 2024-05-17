<?php

namespace App\Controller\Patient\Appointment;

use App\Service\Patient\FindDoctorActionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FindDoctorController extends AbstractController
{
    /**
     * @Route(
     *     "/patient/appointment/find-doctor",
     *     name="front.patient.appointment.find_doctor",
     *     methods={"POST"},
     * )
     * @param Request $request
     * @param FindDoctorActionService $findDoctorActionService
     * @return JsonResponse
     */
    public function index(Request $request, FindDoctorActionService $findDoctorActionService): JsonResponse
    {
        return $findDoctorActionService->getJsonResponse($request);
    }
}
