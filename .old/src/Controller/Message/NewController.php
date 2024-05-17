<?php

namespace App\Controller\Message;

use App\Service\Message\MessageNewService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class NewController extends AbstractController
{
    /**
     * @Route(
     *     "/message/new",
     *     name="front.message.new",
     *     methods={"POST"},
     * )
     * @param MessageNewService $messageNewService
     * @return JsonResponse
     */
    public function index(MessageNewService $messageNewService): JsonResponse
    {
        return $messageNewService->getJsonResponse();
    }
}
