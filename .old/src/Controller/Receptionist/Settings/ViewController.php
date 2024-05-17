<?php

namespace App\Controller\Receptionist\Settings;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/receptionist/settings", name="front.receptionist.settings")
     */
    public function index(): Response
    {
        return $this->render('receptionist/settings.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
