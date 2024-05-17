<?php

namespace App\Controller\Doctor\Settings;

use App\Service\Settings\DoctorSettingsSaveService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SaveController extends AbstractController
{
    /**
     * @Route(
     *     "/doctor/settings/save",
     *     name="front.doctor.settings.save",
     *     methods={"POST"},
     * )
     * @param DoctorSettingsSaveService $saveService
     * @return JsonResponse
     */
    public function index(DoctorSettingsSaveService $saveService): JsonResponse
    {
        return $saveService->getJsonResponse();
    }
}
