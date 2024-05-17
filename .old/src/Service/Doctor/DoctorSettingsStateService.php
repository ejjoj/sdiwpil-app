<?php

namespace App\Service\Doctor;

use App\Service\MedicalSpecialty\FrontEndMedicalSpecialtyService;
use App\Service\Menu\MenuService;
use App\Service\Settings\UserSettingsStateService;
use Symfony\Component\Security\Core\Security;

class DoctorSettingsStateService extends UserSettingsStateService
{
    public function __construct(
        Security $security,
        MenuService $menuService,
        private readonly FrontEndMedicalSpecialtyService $medicalSpecialtyService
    ) {
        parent::__construct($security, $menuService);
    }

    private function getFrontEndWorkingTime(?array $workingTime): ?array
    {
        if (!$workingTime) {
            return null;
        }

        $format = 'H:i';
        foreach ($workingTime as $day => $values) {
            $result[$day] = [
                'start' => $values['start'] ? $values['start']->format($format) : '',
                'end' => $values['end'] ? $values['end']->format($format) : '',
            ];
        }

        return $result ?? null;
    }

    protected function buildState(): void
    {
        parent::buildState();

        $this->state['medicalSpecialty'] = $this->user->getDoctorData()->getMedicalSpecialty()->getId();
        $this->state['medicalSpecialties'] = $this->medicalSpecialtyService->getResult();
        $this->state['workingTime'] = $this->getFrontEndWorkingTime($this->user->getDoctorData()->getWorkingTime());
    }
}
