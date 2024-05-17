<?php

namespace App\Controller\Management\Dashboard;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/management", name="front.management.dashboard")
     */
    public function index(): Response
    {
        return $this->render('management/dashboard.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
