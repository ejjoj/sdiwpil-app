<?php

namespace App\Controller\Profile;

use App\Exception\BadRequestException;
use App\Form\UpdateDoctorProfileType;
use App\Service\Controller\Profile\Create\DependencyContainer;
use App\Service\Controller\Profile\Update\UpdateProcessor;
use App\Service\Entity\DoctorProfile\DoctorProfileFetchingService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

#[Route('/profile')]
class UpdateController extends AbstractCreateUpdateProfileController
{
    public function __construct(
        DependencyContainer $dependencyContainer,
        private readonly UpdateProcessor $updateProcessor,
        private readonly DoctorProfileFetchingService $doctorProfileFetchingService,
    ) {
        parent::__construct($dependencyContainer);
    }

    #[Route('/update', methods: ['PUT'])]
    public function __invoke(): JsonResponse
    {
        try {
            $this->validateRequest();
            $profile = $this->doctorProfileFetchingService->get();
            assert((bool) $profile, new NotFoundHttpException($this->getNotFoundMessage()));
            $content = $this->getRequest()->getContent();
            $payload = json_decode($content ?: '{}', true);
            $form = $this->createForm(UpdateDoctorProfileType::class);
            $form->submit($payload);
            assert($form->isValid(), new BadRequestException($form));
            $this->processUpdate($form);
            $response = $this->getSuccessResponse('doctor.profile.update.200');
        } catch (Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    private function processUpdate(FormInterface $form): void
    {
        $this->updateProcessor
            ->withCustomerId($this->getCustomerId())
            ->withFormData($form->getData())
            ->process();
    }

    private function getNotFoundMessage(): string
    {
        return $this->dependencyContainer
            ->getTranslator()
            ->trans('doctor.profile.update.404');
    }
}
