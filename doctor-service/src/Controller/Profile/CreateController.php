<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class CreateController extends AbstractController
{
    #[Route('/create', methods: ['POST'])]
    public function index(): JsonResponse
    {
        // TODO: handle creation
        return $this->json([
            'message' => 'Create doctor profile',
        ]);
    }
}
