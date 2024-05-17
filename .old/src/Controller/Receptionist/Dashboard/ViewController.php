<?php

namespace App\Controller\Receptionist\Dashboard;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/receptionist", name="front.receptionist.dashboard")
     */
    public function index(): Response
    {
        return $this->render('receptionist/dashboard.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
