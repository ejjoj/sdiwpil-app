<?php

namespace App\Service\Appointment;

use App\Entity\Appointment;
use App\Entity\User;
use App\Form\Appointment\AppointmentNewFormType;
use App\Service\FormErrorService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Utils;
use Psr\Log\LoggerInterface;
use RuntimeException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class AppointmentNewActionService
{
    private const SUCCESS_KEY = 'success';
    private const APPOINTMENTS_KEY = 'appointments';
    private const ERRORS_KEY = 'errors';

    private RequestStack $requestStack;
    private Security $security;
    private FormFactoryInterface $formFactory;
    private FormErrorService $formErrorService;
    private EntityManagerInterface $entityManager;
    private LoggerInterface $logger;

    private Request $request;
    private User $patient;

    private array $result = [
        self::SUCCESS_KEY => false,
        self::APPOINTMENTS_KEY => [],
        self::ERRORS_KEY => [],
    ];

    public function __construct(
        RequestStack $requestStack,
        Security $security,
        FormFactoryInterface $formFactory,
        FormErrorService $formErrorService,
        EntityManagerInterface $entityManager,
        LoggerInterface $logger
    ) {
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->formFactory = $formFactory;
        $this->formErrorService = $formErrorService;
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    public function getJsonResponse(): JsonResponse
    {
        $this->init();

        return new JsonResponse($this->result);
    }

    private function setRequest(): AppointmentNewActionService
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            throw new RuntimeException(sprintf('Request must be an instance of %s', Request::class));
        }

        $this->request = $request;

        return $this;
    }

    private function setPatient(): AppointmentNewActionService
    {
        /** @var User $patient */
        $patient = $this->security->getUser();
        if (!$patient || !in_array(User::ROLE_PATIENT, $patient->getRoles(), true)) {
            throw new RuntimeException('Patient not found');
        }

        $this->patient = $patient;

        return $this;
    }

    private function successfulFormAction(FormInterface $form): void
    {
        /** @var Appointment $appointment */
        $appointment = $form->getData();
        $appointment->setPatient($this->patient->getPatientData());
        $this->entityManager->persist($appointment);
        $this->entityManager->flush();
    }

    /**
     * @return array{min: int, max: int}
     */
    private function getMinMax(): array
    {
        $page = (int)$this->request->get('page', 1);
        $perPage = (int)$this->request->get('per_page', 25);

        return [
            'min' => $perPage * ($page - 1),
            'max' => $perPage,
        ];
    }

    private function setAppointments(): void
    {
        $minMax = $this->getMinMax();
        $appointments = $this->entityManager->getRepository(Appointment::class)
            ->getPaginatedAppointments($this->patient->getPatientData(), $minMax['min'], $minMax['max']);
        foreach ($appointments as $appointment) {
            /** @var Appointment $appointment */
            $this->result[self::APPOINTMENTS_KEY][] = $appointment->toFrontEndPatientArray();
        }
    }

    private function processForm(): void
    {
        $form = $this->formFactory->create(AppointmentNewFormType::class)->submit(
            Utils::jsonDecode($this->request->getContent(), true)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $this->successfulFormAction($form);
            $this->setAppointments();
            $this->result[self::SUCCESS_KEY] = true;
        } else {
            $this->result[self::ERRORS_KEY] = $this->formErrorService->getArray($form);
        }
    }

    private function init(): void
    {
        try {
            $this
                ->setRequest()
                ->setPatient()
                ->processForm();
        } catch (Exception $exception) {
            $this->result[self::ERRORS_KEY][] = ['message' => 'Przepraszamy, wystąpił błąd.'];
            $this->logger->error($exception->getMessage());
        }
    }
}
