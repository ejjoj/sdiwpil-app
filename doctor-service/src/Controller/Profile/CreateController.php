<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Entity\DoctorProfile;
use App\Exception\BadRequestException;
use App\Form\CreateDoctorProfileType;
use App\Service\Controller\Profile\Create\DependencyContainer;
use App\Service\Entity\DoctorProfile\FormToDoctorProfileConverter;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class CreateController extends AbstractCreateUpdateProfileController
{
    public function __construct(
        protected DependencyContainer $dependencyContainer,
        private readonly FormToDoctorProfileConverter $doctorProfileConverter,
    ) {
        parent::__construct($dependencyContainer);
    }

    #[Route('/create', methods: ['POST'])]
    public function __invoke(): JsonResponse
    {
        try {
            $this->validateRequest();
            $content = $this->getRequest()->getContent();
            $payload = json_decode($content, true);
            unset($payload['customerId']);
            $payload['customerId'] = $this->getCustomerId();
            $form = $this->createForm(CreateDoctorProfileType::class);
            $form->submit($payload);
            assert($form->isValid(), new BadRequestException($form));
            $doctorProfile = $this->getDoctorProfile($form);
            $this->saveProfile($doctorProfile);
            $response = $this->getSuccessResponse('doctor.profile.create.201');
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    public function getDoctorProfile(FormInterface $form): DoctorProfile
    {
        return $this->doctorProfileConverter
            ->withData($form->getData())
            ->convert();
    }

    private function saveProfile(DoctorProfile $doctorProfile): void
    {
        $this->dependencyContainer
            ->getEntityManager()
            ->persist($doctorProfile);
        $this->dependencyContainer
            ->getEntityManager()
            ->flush();
    }
}
