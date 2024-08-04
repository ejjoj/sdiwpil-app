<?php

namespace App\Controller;

use App\Exception\BadRequestException;
use App\Form\CreateProfileType;
use App\Model\Response\ResponseModel;
use App\Service\Authorization\PermissionValidator;
use App\Service\Authorization\UserFlyweight;
use App\Service\Entity\PatientProfile\Converter\FormToPatientProfileConverter;
use App\Service\Request\TokenRepository;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponse\SuccessResponseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatableInterface;

#[Route('/profile')]
class CreateProfileController extends AbstractController
{
    public function __construct(
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        private readonly PermissionValidator $permissionValidator,
        private readonly UserFlyweight $userFlyweight,
        private readonly TokenRepository $tokenRepository,
        private readonly FormToPatientProfileConverter $formToPatientProfileConverter,
        private readonly EntityManagerInterface $entityManager,
        private readonly SuccessResponseBuilder $successResponseBuilder,
        private readonly TranslatableInterface $translator,
    ) {
    }

    #[Route('/create', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $token = $this->tokenRepository->find();
            $this->permissionValidator->validate($token);
            $payload = json_decode($request->getContent() ?: '{}', true);
            $form = $this->createForm(CreateProfileType::class);
            $form->submit($payload);
            assert($form->isValid(), new BadRequestException($form));
            $data = $form->getData();
            $data['customerId'] = $this->userFlyweight->getUser($token)?->getId();
            $patientProfile = $this->formToPatientProfileConverter
                ->withData($data)
                ->convert();
            $this->entityManager->persist($patientProfile);
            $this->entityManager->flush();
            $response = $this->getSuccessfulResponse();
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function getSuccessfulResponse(): ResponseModel
    {
        return $this->successResponseBuilder
            ->withMessage($this->translator->trans('patient.profile.create.201'))
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
