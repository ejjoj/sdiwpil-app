<?php

namespace App\Service\Controller\Profile\Update;

use App\Entity\DoctorProfile;
use App\Service\Entity\DoctorProfile\FormToDoctorProfileConverter;
use Doctrine\ORM\EntityManagerInterface;

readonly class UpdateProcessor
{
    private int $customerId;
    private array $formData;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private FormToDoctorProfileConverter $formToDoctorProfileConverter,
    ) {
    }

    public function withCustomerId(int $customerId): static
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function withFormData(array $formData): static
    {
        $this->formData = $formData;

        return $this;
    }

    public function process(): void
    {
        $doctorProfile = $this->getDoctorProfile();
        $this->populateDataIntoProfile($doctorProfile);
        $this->saveProfile($doctorProfile);
    }

    private function getDoctorProfile(): ?DoctorProfile
    {
        return $this->entityManager
            ->getRepository(DoctorProfile::class)
            ->findOneBy(['customerId' => $this->customerId]);
    }

    private function populateDataIntoProfile(?DoctorProfile $doctorProfile): void
    {
        $this->formToDoctorProfileConverter
            ->withDoctorProfile($doctorProfile)
            ->withData($this->formData)
            ->convert();
    }

    private function saveProfile(?DoctorProfile $doctorProfile): void
    {
        $this->entityManager->persist($doctorProfile);
        $this->entityManager->flush();
    }
}
