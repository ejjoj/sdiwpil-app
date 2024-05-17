<?php

namespace App\Controller\Doctor\Settings;

use App\Service\Doctor\DoctorSettingsStateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/doctor/settings", name="front.doctor.settings")
     */
    public function index(DoctorSettingsStateService $stateService): Response
    {
        return $this->render('doctor/settings.html.twig', [
            'state' => $stateService->getState(),
        ]);
    }
}
