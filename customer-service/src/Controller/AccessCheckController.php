<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccessCheckController extends AbstractController
{
    #[Route(path: '/access/check', methods: ["GET"])]
    public function index(): Response
    {
        return $this->json(['test']);
    }
}
