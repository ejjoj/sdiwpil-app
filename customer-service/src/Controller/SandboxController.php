<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SendEmailMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class SandboxController extends AbstractController
{
    #[Route(path: '/sandbox', name: 'sandbox')]
    public function index(MessageBusInterface $messageBus): JsonResponse
    {
        $messageBus->dispatch(new SendEmailMessage(
            'szymaskibartosz@gmail.com',
            'Test e-mail',
            'To jest testowy e-mail wysłany z mikroserwisu',
        ));

        return $this->json('Sandbox');
    }
}
