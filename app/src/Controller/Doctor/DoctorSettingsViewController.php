<?php

namespace App\Controller\Doctor;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DoctorSettingsViewController extends AbstractController
{
    /**
     * @Route("/doctor/settings", name="front.doctor.settings")
     */
    public function index(): Response
    {
        return $this->render('doctor/settings.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
