<?php

namespace App\Controller\Patient\Settings;

use App\Service\Settings\UserSettingsSaveService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SaveController extends AbstractController
{
    /**
     * @Route(
     *     "/patient/settings/save",
     *     name="front.patient.settings.save",
     *     methods={"POST"},
     * )
     * @param UserSettingsSaveService $saveService
     * @return JsonResponse
     */
    public function index(UserSettingsSaveService $saveService): JsonResponse
    {
        return $saveService->getJsonResponse();
    }
}
