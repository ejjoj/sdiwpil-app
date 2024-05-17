<?php

namespace App\Controller\Receptionist\AppointmentManagement;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/receptionist/appointment-management", name="front.receptionist.appointment_management")
     */
    public function index(): Response
    {
        return $this->render('receptionist/appointment_management.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
