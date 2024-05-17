<?php

namespace App\Controller\Patient\Register;

use App\Service\Patient\PatientRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    public const ROUTE_NAME = 'front.patient.register.new';

    /**
     * @Route(
     *     "/patient/register/new",
     *     name="front.patient.register.new",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @param PatientRegisterService $registerService
     * @return JsonResponse
     */
    public function index(Request $request, PatientRegisterService $registerService): JsonResponse
    {
        return $this->json($registerService->handleRequest($request));
    }
}
