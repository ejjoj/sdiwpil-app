<?php

namespace App\Controller\Login;

use App\Service\Menu\MenuService;
use App\Service\RegisterInterlinkingService;
use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/login", name="front.login")
     */
    public function index(RegisterInterlinkingService $interlinkingService, MenuService $menuService): Response
    {
        return $this->render('login/index.html.twig', [
            'state' => Utils::jsonEncode([
                'register_interlinking' => $interlinkingService->get(),
                'menu' => $menuService->getMenu(),
            ]),
        ]);
    }
}
