<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Exception\BadRequestException;
use App\Form\DoctorProfileType;
use App\Model\Response\ResponseModel;
use App\Service\Authorization\PermissionValidator;
use App\Service\Authorization\UserFlyweight;
use App\Service\Entity\DoctorProfile\DoctorProfileConverter;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/profile')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly PermissionValidator $permissionValidator,
        private readonly UserFlyweight $userFlyweight,
        private readonly SuccessResponseBuilder $successResponseBuilder,
        private readonly TranslatorInterface $translator,
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        private readonly DoctorProfileConverter $doctorProfileConverter,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/create', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $token = $request->headers->get('authorization');
            $this->permissionValidator->validate($token);
            $content = $request->getContent();
            $payload = json_decode($content, true);
            unset($payload['customerId']);
            $payload['customerId'] = $this->userFlyweight->getUser($token)?->getId();
            $form = $this->createForm(DoctorProfileType::class);
            $form->submit($payload);
            assert($form->isValid(), new BadRequestException($form));
            $doctorProfile = $this->doctorProfileConverter->convert($form->getData());
            $this->entityManager->persist($doctorProfile);
            $this->entityManager->flush();
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
            ->withMessage($this->translator->trans('doctor.profile.create.201'))
            ->build();
    }

    private function getErrorResponse(\Throwable $exception): ResponseModel
    {
        return $this->errorResponseStrategyResolver
            ->withException($exception)
            ->resolve()
            ->get();
    }
}
