<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Service\Authorization\PermissionValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class CreateController extends AbstractController
{
    public function __construct(private readonly PermissionValidator $permissionValidator)
    {
    }

    #[Route('/create', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $this->permissionValidator->validate($request->headers->get('authorization'));
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
        // TODO: handle creation
        return $this->json([
            'message' => 'Create doctor profile',
        ]);
    }
}
