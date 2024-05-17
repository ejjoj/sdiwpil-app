<?php

namespace App\Controller\Doctor\Register;

use App\Service\Doctor\DoctorRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    public const ROUTE_NAME = 'front.doctor.register.new';

    /**
     * @Route(
     *     "/doctor/register/new",
     *     name="front.doctor.register.new",
     *     methods={"POST"},
     * )
     * @param Request $request
     * @param DoctorRegisterService $registerService
     * @return JsonResponse
     */
    public function index(Request $request, DoctorRegisterService $registerService): JsonResponse
    {
        return $this->json($registerService->handleRequest($request));
    }
}
