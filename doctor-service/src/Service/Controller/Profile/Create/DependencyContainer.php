<?php

namespace App\Service\Controller\Profile\Create;

use App\Service\Authorization\PermissionValidator;
use App\Service\Authorization\UserFlyweight;
use App\Service\Request\RequestExtractor;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponse\SuccessResponseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DependencyContainer
{
    public function __construct(
        protected PermissionValidator $permissionValidator,
        protected UserFlyweight $userFlyweight,
        protected SuccessResponseBuilder $successResponseBuilder,
        protected TranslatorInterface $translator,
        protected ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        protected EntityManagerInterface $entityManager,
        protected RequestExtractor $requestExtractor,
    ) {
    }

    public function getPermissionValidator(): PermissionValidator
    {
        return $this->permissionValidator;
    }

    public function getUserFlyweight(): UserFlyweight
    {
        return $this->userFlyweight;
    }

    public function getSuccessResponseBuilder(): SuccessResponseBuilder
    {
        return $this->successResponseBuilder;
    }

    public function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    public function getErrorResponseStrategyResolver(): ErrorResponseStrategyResolver
    {
        return $this->errorResponseStrategyResolver;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getRequestExtractor(): RequestExtractor
    {
        return $this->requestExtractor;
    }
}
