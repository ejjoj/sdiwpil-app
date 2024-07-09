<?php

namespace App\Controller\Profile;

use App\Exception\AccessDeniedException;
use App\Model\Response\ResponseModel;
use App\Service\Controller\Profile\Create\DependencyContainer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class AbstractProfileController extends AbstractController
{
    abstract public function index(): JsonResponse;

    public function __construct(
        protected DependencyContainer $dependencyContainer,
    ) {
    }

    /**
     * @throws AccessDeniedException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    protected function validateRequest(): void
    {
        $token = $this->getRequest()->headers->get('authorization');
        $this->dependencyContainer
            ->getPermissionValidator()
            ->validate($token);
    }

    protected function getRequest(): Request
    {
        return $this->dependencyContainer
            ->getRequestExtractor()
            ->extract();
    }

    protected function getSuccessResponse(string $translationId): ResponseModel
    {
        $message = $this->dependencyContainer
            ->getTranslator()
            ->trans($translationId);

        return $this->dependencyContainer
            ->getSuccessResponseBuilder()
            ->withMessage($message)
            ->build();
    }

    protected function getErrorResponse(\Throwable $exception): ResponseModel
    {
        return $this->dependencyContainer
            ->getErrorResponseStrategyResolver()
            ->withException($exception)
            ->resolve()
            ->get();
    }
}
