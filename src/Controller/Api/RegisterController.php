<?php

namespace App\Controller\Api;

use App\Model\Response\ResponseModel;
use App\Service\Controller\Api\RegisterController\DataValidator;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/api', name: 'api.')]
class RegisterController extends AbstractController
{
    public function __construct(
        private readonly DataValidator $dataValidator,
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        private readonly SuccessResponseBuilder $successResponseBuilder,
        private readonly TranslatorInterface $translator,
    ) {
    }

    #[Route('/register', name: 'register', methods: 'POST')]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $decoded = json_decode($request->getContent(), true);
            $this->dataValidator
                ->withData($decoded ?? [])
                ->validate();
            $response = $this->getSuccessResponse();
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getSuccessResponse(): ResponseModel
    {
        return $this->successResponseBuilder
            ->withMessage($this->translator->trans('success.register'))
            ->build();
    }

    private function getErrorResponse(\Exception $exception): ResponseModel
    {
        return $this->errorResponseStrategyResolver
            ->withException($exception)
            ->resolve()
            ->get();
    }
}
