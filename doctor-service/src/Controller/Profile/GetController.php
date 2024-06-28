<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Entity\DoctorProfile;
use App\Model\Response\ResponseModel;
use App\Repository\DoctorProfileRepository;
use App\Service\Authorization\PermissionValidator;
use App\Service\Authorization\UserFlyweight;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponse\DoctorProfileSuccessResponseBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/profile')]
class GetController extends AbstractController
{
    public function __construct(
        private readonly PermissionValidator $permissionValidator,
        private readonly UserFlyweight $userFlyweight,
        private readonly TranslatorInterface $translator,
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        private readonly DoctorProfileRepository $doctorProfileRepository,
        private readonly DoctorProfileSuccessResponseBuilder $doctorProfileSuccessResponseBuilder,
    ) {
    }

    #[Route('/get', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $token = $request->headers->get('authorization');
            $this->permissionValidator->validate($token);
            $customerId = $this->userFlyweight->getUser($token)?->getId();
            $profile = $this->doctorProfileRepository->find($customerId);
            assert((bool) $profile, new NotFoundHttpException($this->getNotFoundMessage()));
            $response = $this->getSuccessResponse($profile);
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getSuccessResponse(DoctorProfile $doctorProfile): ResponseModel
    {
        return $this->doctorProfileSuccessResponseBuilder
            ->withMessage($this->translator->trans('doctor.profile.get.200'))
            ->withDoctorProfile($doctorProfile)
            ->build();
    }

    private function getErrorResponse(\Throwable $exception): ResponseModel
    {
        return $this->errorResponseStrategyResolver
            ->withException($exception)
            ->resolve()
            ->get();
    }

    private function getNotFoundMessage(): string
    {
        return $this->translator->trans('doctor.profile.get.404');
    }
}
