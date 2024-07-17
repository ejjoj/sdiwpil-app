<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ORM\Index(name: "idx_patient_profile_id", columns: ["patient_profile_id"])]
#[ORM\Index(name: "idx_doctor_profile_id", columns: ["doctor_profile_id"])]
#[ORM\Index(name: "idx_scheduled_at", columns: ["scheduled_at"])]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $patientProfileId = null;

    #[ORM\Column]
    private ?int $doctorProfileId = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $scheduledAt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $patientReasonForAppointment = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $doctorNotes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientProfileId(): ?int
    {
        return $this->patientProfileId;
    }

    public function setPatientProfileId(int $patientProfileId): static
    {
        $this->patientProfileId = $patientProfileId;

        return $this;
    }

    public function getDoctorProfileId(): ?int
    {
        return $this->doctorProfileId;
    }

    public function setDoctorProfileId(int $doctorProfileId): static
    {
        $this->doctorProfileId = $doctorProfileId;

        return $this;
    }

    public function getScheduledAt(): ?\DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(\DateTimeImmutable $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getPatientReasonForAppointment(): ?string
    {
        return $this->patientReasonForAppointment;
    }

    public function setPatientReasonForAppointment(string $patientReasonForAppointment): static
    {
        $this->patientReasonForAppointment = $patientReasonForAppointment;

        return $this;
    }

    public function getDoctorNotes(): ?string
    {
        return $this->doctorNotes;
    }

    public function setDoctorNotes(?string $doctorNotes): static
    {
        $this->doctorNotes = $doctorNotes;

        return $this;
    }
}
