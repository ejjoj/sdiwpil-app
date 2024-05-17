<?php

namespace App\Controller\Doctor\Documents;

use App\Controller\AbstractViewDocumentsListController;
use App\Entity\Document;
use App\Entity\PatientData;
use App\Entity\User;
use App\Service\Menu\MenuService;
use GuzzleHttp\Utils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractViewDocumentsListController
{
    /**
     * @Route("/doctor/documents", name="front.doctor.documents")
     */
    public function index(MenuService $menuService): Response
    {
        return $this->render('doctor/documents.html.twig', [
            'state' => Utils::jsonEncode([
                'patients' => $this->getPatients(),
                'documentTypes' => $this->getDocumentTypes(),
                'doctor' => $this->getUser()->getDoctorData()->getId(),
                'documents' => $this->getDocuments(),
                'menu' => $menuService->getMenu(),
            ]),
        ]);
    }

    private function getPatients(): array
    {
        /** @var User $doctor */
        $doctor = $this->getUser();
        /** @var PatientData[] $patients */
        $patients = $this->entityManager->getRepository(PatientData::class)
            ->findPatientsDataByDoctorDataInAppointment($doctor->getDoctorData());
        foreach ($patients as $patient) {
            $patientUser = $patient->getPatient();
            $result[] = [
                'text' => $patientUser->getFirstName() . ' ' . $patientUser->getLastName(),
                'value' => $patient->getId(),
            ];
        }

        return $result ?? [];
    }

    private function getDocumentTypes(): array
    {
        return [
            [
                'text' => 'Recepta',
                'value' => Document::PRESCRIPTION_TYPE,
            ]
        ];
    }
}
