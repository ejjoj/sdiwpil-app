<?php

namespace App\Service\Patient;

use App\Entity\User;
use App\Form\FindDoctorFormType;
use App\Repository\UserRepository;
use App\Service\FormErrorService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Utils;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FindDoctorActionService
{
    private const SUCCESS_KEY = 'success';
    private const DOCTORS_KEY = 'doctors';
    private const ERRORS_KEY = 'errors';

    private Request $request;

    private array $result = [
        self::SUCCESS_KEY => false,
        self::DOCTORS_KEY => [],
        self::ERRORS_KEY => [],
    ];

    public function __construct(
        private readonly FormFactoryInterface $formFactory,
        private readonly FormErrorService $formErrorService,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    ) {
    }

    public function getJsonResponse(Request $request): JsonResponse
    {
        $this->request = $request;
        $this->process();

        return new JsonResponse($this->result);
    }

    private function handleException(Exception $exception): void
    {
        $this->logger->error($exception->getMessage());
        $this->result[self::ERRORS_KEY][] = ['message' => 'Coś poszło nie tak, przepraszamy'];
    }

    /**
     * @param User[] $doctors
     * @return void
     */
    private function setDoctors(array $doctors): void
    {
        foreach ($doctors as $doctor) {
            $frontEndDoctors[] = $doctor->toArray();
        }

        $this->result[self::SUCCESS_KEY] = true;
        $this->result[self::DOCTORS_KEY] = $frontEndDoctors ?? [];
    }

    private function handleDoctorSearch(array $searchParams): void
    {
        /** @var UserRepository $repository */
        $repository = $this->entityManager->getRepository(User::class);
        $doctors = $repository->findDoctorByAppointmentParams($searchParams);
        if (empty($doctors)) {
            $this->result[self::ERRORS_KEY][] = [
                'message' => 'Nie znaleziono lekarzy o podanych parametrach wyszukiwnaia',
            ];

            return;
        }

        $this->setDoctors($doctors);
    }

    private function process(): void
    {
        try {
            $form = $this->formFactory->create(FindDoctorFormType::class)->submit(
                Utils::jsonDecode($this->request->getContent(), true)
            );
            if (!$form->isSubmitted() || !$form->isValid()) {
                $this->result[self::ERRORS_KEY] = $this->formErrorService->getArray($form);

                return;
            }

            $this->handleDoctorSearch($form->getData());
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }
}
