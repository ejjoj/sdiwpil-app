<?php

namespace App\Controller;

use App\Model\Response\ResponseModel;
use App\Service\Response\ErrorResponseStrategyResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class CreateAppointmentController extends AbstractController
{
    public function __construct(
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver
    ) {
    }

    #[Route('/create', methods: ['POST'])]
    public function index(): JsonResponse
    {
        try {
            $response = $this->getSuccessResponse();
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getSuccessResponse(): ResponseModel
    {
        return new ResponseModel(); // TODO: Implement this method
    }

    private function getErrorResponse(\Throwable $exception): ResponseModel
    {
        return $this->errorResponseStrategyResolver
            ->withException($exception)
            ->resolve()
            ->get();
    }
}
