<?php

namespace App\Controller\Management\Settings;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/management/settings", name="front.management.settings")
     */
    public function index(): Response
    {
        return $this->render('management/settings.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
