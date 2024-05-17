<?php

namespace App\Controller\Management\Statistics;

use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/management/statistics", name="front.management.statistics")
     */
    public function index(): Response
    {
        return $this->render('management/statistics.html.twig', [
            'state' => Utils::jsonEncode([]),
        ]);
    }
}
