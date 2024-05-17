<?php

namespace App\Controller\Patient\Dashboard;

use App\Service\Menu\MenuService;
use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    public const ROUTE_NAME = 'front.patient.dashboard';

    /**
     * @Route("/patient", name="front.patient.dashboard")
     */
    public function index(MenuService $menuService): Response
    {
        return $this->render('patient/dashboard.html.twig', [
            'state' => Utils::jsonEncode([
                'menu' => $menuService->getMenu(),
            ]),
        ]);
    }
}
