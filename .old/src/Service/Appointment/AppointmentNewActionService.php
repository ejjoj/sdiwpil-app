<?php

namespace App\Service\Appointment;

use App\Entity\Appointment;
use App\Entity\Conversation;
use App\Entity\User;
use App\Exception\AppointmentException;
use App\Form\Appointment\AppointmentNewFormType;
use App\Service\FormErrorService;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
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

    private Request $request;
    private User $patient;

    private array $result = [
        self::SUCCESS_KEY => false,
        self::APPOINTMENTS_KEY => [],
        self::ERRORS_KEY => [],
    ];

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly Security $security,
        private readonly FormFactoryInterface $formFactory,
        private readonly FormErrorService $formErrorService,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    ) {
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

    private function createAppointment(Appointment $appointment): Appointment
    {
        $appointment->setPatient($this->patient->getPatientData());
        $this->entityManager->persist($appointment);

        return $appointment;
    }

    private function createConversation(Appointment $appointment): void
    {
        $doctor = $appointment->getDoctor()->getDoctor();
        $title = sprintf(
            '%s %s. i lek. %s %s.',
            $this->patient->getFirstName(),
            substr($this->patient->getLastName(), 0, 1),
            $doctor->getFirstName(),
            substr($doctor->getLastName(), 0, 1),
        );
        $conversation = (new Conversation())
            ->setPatient($this->patient->getPatientData())
            ->setDoctor($appointment->getDoctor())
            ->setTitle($title)
            ->setChannelId($appointment->getChecksum());

        $this->entityManager->persist($conversation);
    }

    private function isExistingConversation(Appointment $appointment): bool
    {
        return (bool)$this->entityManager->getRepository(Conversation::class)->findOneBy([
            'patient' => $appointment->getPatient(),
            'doctor' => $appointment->getDoctor(),
        ]);
    }

    private function successfulFormAction(FormInterface $form): void
    {
        $appointment = $this->createAppointment($form->getData());
        $this->entityManager->flush();
        if (!$this->isExistingConversation($appointment)) {
            $this->createConversation($appointment);
            $this->entityManager->flush();
        }
    }

    #[ArrayShape(['min' => "float|int", 'max' => "int"])] private function getMinMax(): array
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

    private function isExistingAppointment(Appointment $appointment): bool
    {
        return (bool)$this->entityManager->getRepository(Appointment::class)->findOneBy([
            'scheduledAt' => $appointment->getScheduledAt(),
            'doctor' => $appointment->getDoctor(),
        ]);
    }

    private function isLessThan30MinutesToAppointment(Appointment $appointment): bool
    {
        $scheduledAt = new Carbon($appointment->getScheduledAt());

        return $scheduledAt->diffInMinutes(Carbon::now()) < 30;
    }

    /**
     * @throws AppointmentException
     */
    private function checkIfExists(Appointment $appointment): void
    {
        if ($this->isExistingAppointment($appointment)) {
            throw new AppointmentException(
                'Wybrany lekarz i godzina wizyty zostały już zarezerwowane, wybierz inny termin.'
            );
        }
    }

    /**
     * @throws AppointmentException
     */
    private function checkIfLessThan30MinutesToAppointment(Appointment $appointment): void
    {
        if ($this->isLessThan30MinutesToAppointment($appointment)) {
            throw new AppointmentException('Nie można zarezerwować wybranego terminu, wybierz inny termin');
        }
    }

    /**
     * @throws AppointmentException
     */
    private function processForm(): void
    {
        $form = $this->formFactory->create(AppointmentNewFormType::class)->submit(
            Utils::jsonDecode($this->request->getContent(), true)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Appointment $appointment */
            $appointment = $form->getData();
            $this->checkIfExists($appointment);
            $this->checkIfLessThan30MinutesToAppointment($appointment);
            $this->successfulFormAction($form);
            $this->setAppointments();
            $this->result[self::SUCCESS_KEY] = true;
        } else {
            $this->result[self::ERRORS_KEY] = $this->formErrorService->getArray($form);
        }
    }

    private function handleException(Exception $exception): void
    {
        if (!($exception instanceof AppointmentException)) {
            $this->result[self::ERRORS_KEY][] = ['message' => 'Przepraszamy, wystąpił błąd.'];
            $this->logger->error($exception->getMessage());

            return;
        }

        $this->result[self::ERRORS_KEY][] = ['message' => $exception->getMessage()];
    }

    private function init(): void
    {
        try {
            $this
                ->setRequest()
                ->setPatient()
                ->processForm();
        } catch (Exception $exception) {
            $this->handleException($exception);
        }
    }
}
