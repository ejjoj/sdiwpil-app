<?php

namespace App\Service\Settings;

use App\Entity\DoctorData;
use App\Entity\MedicalSpecialty;
use App\Entity\User;
use App\Form\Settings\DoctorSettingsFormType;

class DoctorSettingsSaveService extends UserSettingsSaveService
{
    protected static string $settingsFormType = DoctorSettingsFormType::class;

    private function handleMedicalSpecialtySave(User $doctor, array $data): void
    {
        /** @var MedicalSpecialty $medicalSpecialty */
        $medicalSpecialty = $data['medicalSpecialty'] ?? null;
        if ($medicalSpecialty) {
            /** @var DoctorData $doctorData */
            $doctorData = $doctor->getDoctorData();
            $doctorData->setMedicalSpecialty($medicalSpecialty);
            $this->entityManager->persist($doctorData);
        }
    }

    private function handleWorkingTimeSave(User $doctor, array $data): void
    {
        $workingTime = $data['workingTime'] ?? null;
        if ($workingTime) {
            /** @var DoctorData $doctorData */
            $doctorData = $doctor->getDoctorData();
            $doctorData->setWorkingTime($workingTime);
            $this->entityManager->persist($doctorData);
        }
    }

    protected function populateUserData(User $user, array $data): void
    {
        parent::populateUserData($user, $data);

        $this->handleMedicalSpecialtySave($user, $data);
        $this->handleWorkingTimeSave($user, $data);
    }
}
