<?php

namespace App\Controller\Patient\Appointment;

use App\Entity\Appointment;
use App\Entity\User;
use App\Service\MedicalSpecialty\FrontEndMedicalSpecialtyService;
use App\Service\Menu\MenuService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @Route("/patient/appointment", name="front.patient.appointment")
     */
    public function index(
        FrontEndMedicalSpecialtyService $medicalSpecialtyService,
        MenuService $menuService
    ): Response {
        return $this->render('patient/appointment.html.twig', [
            'state' => Utils::jsonEncode([
                'medical_specialties' => $medicalSpecialtyService->getResult(),
                'appointments' => $this->getAppointments(),
                'menu' => $menuService->getMenu(),
            ]),
        ]);
    }

    private function getAppointments(): array
    {
        /** @var User $patient */
        $patient = $this->getUser();
        $appointments = $this->entityManager->getRepository(Appointment::class)
            ->getPaginatedAppointments($patient->getPatientData(), 0, 25);
        foreach ($appointments as $appointment) {
            /** @var Appointment $appointment */
            $result[] = $appointment->toFrontEndPatientArray();
        }

        return $result ?? [];
    }
}
