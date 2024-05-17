<?php

namespace App\Controller\Receptionist\RegisterManagement;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/receptionist/register-management", name="front.receptionist.register_management")
     */
    public function index(): Response
    {
        return $this->render('receptionist/register_management.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
