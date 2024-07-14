<?php

namespace App\Controller\Profile;

use App\Service\Controller\Profile\Create\DependencyContainer;
use App\Service\Entity\DoctorProfile\DoctorProfileFetchingService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class DeleteController extends AbstractProfileController
{
    public function __construct(
        DependencyContainer $dependencyContainer,
        private readonly DoctorProfileFetchingService $doctorProfileFetchingService,
    ) {
        parent::__construct($dependencyContainer);
    }

    #[Route('/delete', methods: ['DELETE'])]
    public function __invoke(): JsonResponse
    {
        try {
            $this->validateRequest();
            $profile = $this->doctorProfileFetchingService->get();
            assert((bool) $profile, new NotFoundHttpException($this->getNotFoundMessage()));
            $this->dependencyContainer->getEntityManager()->remove($profile);
            $this->dependencyContainer->getEntityManager()->flush();
            $response = $this->getSuccessResponse('doctor.profile.delete.200');
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getNotFoundMessage(): string
    {
        return $this->dependencyContainer
            ->getTranslator()
            ->trans('doctor.profile.delete.404');
    }
}
