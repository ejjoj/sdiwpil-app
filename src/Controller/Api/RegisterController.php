<?php

namespace App\Controller\Api;

use App\Exception\BadRequestException;
use App\Form\UserType;
use App\Service\Controller\Api\RegisterController\DataValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api', name: 'api.')]
class RegisterController extends AbstractController
{
    public function __construct(
        private DataValidator $dataValidator,
    )
    {
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function index(Request $request): JsonResponse
    {
        $decoded = json_decode($request->getContent(), true);
        $this->dataValidator
            ->withData($decoded)
            ->validate();
        // TODO: check why catching BadRequestException doesn't work and it falls to finally block
    }
}
