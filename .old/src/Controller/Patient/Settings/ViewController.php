<?php

namespace App\Controller\Patient\Settings;

use App\Service\Settings\UserSettingsStateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/patient/settings", name="front.patient.settings")
     */
    public function index(UserSettingsStateService $stateService): Response
    {
        return $this->render('patient/settings.html.twig', [
            'state' => $stateService->getState(),
        ]);
    }
}
