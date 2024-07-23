<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Response\ResponseModel;
use App\Service\Model\GetAppointmentDates\SuccessfulResponseBuilder;
use App\Service\Response\ErrorResponseStrategy\AccessDeniedErrorResponseStrategy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dates')]
class GetAppointmentDatesController extends AbstractController
{
    public function __construct(
        private readonly SuccessfulResponseBuilder $successfulResponseBuilder,
        private readonly AccessDeniedErrorResponseStrategy $accessDeniedErrorResponseStrategy
    ) {
    }

    #[Route(
        '/get/{doctorProfileId}',
        requirements: ['doctorProfileId' => '\d+'],
        methods: ['GET'],
    )]
    public function __invoke(int $doctorProfileId): JsonResponse
    {
        try {
            $response = $this->getSuccessResponse($doctorProfileId);
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getSuccessResponse(int $doctorProfileId): ResponseModel
    {
        return $this->successfulResponseBuilder
            ->withDoctorProfileId($doctorProfileId)
            ->build();
    }

    private function getErrorResponse(\Throwable $exception): ResponseModel
    {
        return $this->accessDeniedErrorResponseStrategy
            ->withException($exception)
            ->get();
    }
}
