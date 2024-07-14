<?php

declare(strict_types=1);

namespace App\Controller\Profile\WorkingTime;

use App\Entity\DoctorProfile;
use App\Model\Response\DoctorProfile\WorkingTime\GetDataModel;
use App\Model\Response\ResponseModel;
use App\Service\Entity\DoctorProfile\WorkingHours\GetWorkingTimeResponseModelConverter;
use App\Service\Response\ErrorResponseStrategyResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/profile/working-time')]
class GetController extends AbstractController
{
    public function __construct(
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        private readonly EntityManagerInterface $entityManager,
        private readonly TranslatorInterface $translator,
        private readonly GetWorkingTimeResponseModelConverter $responseModelConverter,
    ) {
    }

    #[Route('/get/{id}', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        try {
            $profile = $this->getDoctorProfile($id);
            assert((bool) $profile, new NotFoundHttpException($this->getProfileNotFoundMessage()));
            $response = $this->getSuccessResponse($profile);
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getDoctorProfile(int $id): ?DoctorProfile
    {
        return $this->entityManager
            ->getRepository(DoctorProfile::class)
            ->find($id);
    }

    private function getErrorResponse(\Throwable $exception): ResponseModel
    {
        return $this->errorResponseStrategyResolver
            ->withException($exception)
            ->resolve()
            ->get();
    }

    private function getProfileNotFoundMessage(): string
    {
        return $this->translator->trans('doctor.profile.working_time.get.404');
    }

    private function getSuccessResponse(?DoctorProfile $profile): ResponseModel
    {
        return $this->responseModelConverter
            ->withDoctorProfile($profile)
            ->convert();
    }
}
