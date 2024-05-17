<?php

namespace App\Controller\Doctor\Register;

use App\Service\Clinic\FrontEndClinicService;
use App\Service\MedicalSpecialty\FrontEndMedicalSpecialtyService;
use App\Service\Menu\MenuService;
use App\Service\RegisterInterlinkingService;
use GuzzleHttp\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/doctor/register", name="front.doctor.register")
     */
    public function index(
        FrontEndMedicalSpecialtyService $medicalSpecialtyService,
        FrontEndClinicService $clinicService,
        RegisterInterlinkingService $interlinkingService,
        MenuService $menuService
    ): Response {
        return $this->render('doctor/register.html.twig', [
            'state' => Utils::jsonEncode([
                'medical_specialties' => $medicalSpecialtyService->getResult(),
                'clinics' => $clinicService->getResult(),
                'register_interlinking' => $interlinkingService->get('front.doctor.register'),
                'menu' => $menuService->getMenu(),
            ]),
        ]);
    }
}
