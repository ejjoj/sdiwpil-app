<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Entity\DoctorProfile;
use App\Model\Response\ResponseModel;
use App\Service\Authorization\PermissionValidator;
use App\Service\Authorization\UserFlyweight;
use App\Service\Controller\Profile\Create\DependencyContainer;
use App\Service\Entity\DoctorProfile\DoctorProfileFetchingService;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponse\DoctorProfileSuccessResponseBuilder;
use App\Service\Response\SuccessResponse\SuccessResponseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/profile')]
class GetController extends AbstractProfileController
{
    public function __construct(
        protected DependencyContainer $dependencyContainer,
        protected PermissionValidator $permissionValidator,
        protected UserFlyweight $userFlyweight,
        protected SuccessResponseBuilder $successResponseBuilder,
        protected TranslatorInterface $translator,
        protected ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        protected EntityManagerInterface $entityManager,
        protected RequestStack $requestStack,
        private readonly DoctorProfileSuccessResponseBuilder $doctorProfileSuccessResponseBuilder,
        private readonly DoctorProfileFetchingService $doctorProfileFetchingService,
    ) {
        parent::__construct($dependencyContainer);
    }

    #[Route('/get', methods: ['GET'])]
    public function index(): JsonResponse
    {
        try {
            $this->validateRequest();
            $profile = $this->getDoctorProfile();
            assert((bool) $profile, new NotFoundHttpException($this->getNotFoundMessage()));
            $response = $this->getSuccessResponse('doctor.profile.get.200');
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    protected function getSuccessResponse(string $translationId): ResponseModel
    {
        $message = $this->dependencyContainer
            ->getTranslator()
            ->trans($translationId);

        return $this->doctorProfileSuccessResponseBuilder
            ->withMessage($message)
            ->withDoctorProfile($this->getDoctorProfile())
            ->build();
    }

    private function getDoctorProfile(): ?DoctorProfile
    {
        return $this->doctorProfileFetchingService->get();
    }

    private function getNotFoundMessage(): string
    {
        return $this->translator->trans('doctor.profile.get.404');
    }
}
