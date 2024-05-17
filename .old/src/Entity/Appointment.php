<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\ManyToOne(targetEntity=PatientData::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private PatientData $patient;

    /**
     * @ORM\ManyToOne(targetEntity=DoctorData::class, inversedBy="appointments")
     * @ORM\JoinColumn(nullable=false)
     */
    private DoctorData $doctor;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $scheduledAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $patientReason;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $doctorNotes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): PatientData
    {
        return $this->patient;
    }

    public function setPatient(PatientData $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDoctor(): DoctorData
    {
        return $this->doctor;
    }

    public function setDoctor(DoctorData $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getScheduledAt(): ?DateTime
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(?DateTime $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getPatientReason(): string
    {
        return $this->patientReason;
    }

    public function setPatientReason(string $patientReason): self
    {
        $this->patientReason = $patientReason;

        return $this;
    }

    public function getDoctorNotes(): ?string
    {
        return $this->doctorNotes;
    }

    public function setDoctorNotes(?string $doctorNotes): self
    {
        $this->doctorNotes = $doctorNotes;

        return $this;
    }

    #[ArrayShape([
        'id' => "int|null",
        'scheduledAt' => "string",
        'doctor' => "string",
        'medicalSpecialty' => "string",
        'patientReason' => "string"
    ])] public function toFrontEndPatientArray(): array
    {
        return [
            'id' => $this->id,
            'scheduledAt' => $this->scheduledAt->format('d.m.Y H:i'),
            'doctor' => sprintf(
                '%s %s',
                $this->doctor->getDoctor()->getFirstName(),
                $this->doctor->getDoctor()->getLastName()
            ),
            'medicalSpecialty' => $this->doctor->getMedicalSpecialty()->getTitle(),
            'patientReason' => $this->patientReason,
        ];
    }

    #[ArrayShape([
        'id' => "int|null",
        'scheduledAt' => "string",
        'patient' => "string",
        'medicalSpecialty' => "null|string",
        'patientReason' => "string"
    ])] public function toFrontEndDoctorArray(): array
    {
        return [
            'id' => $this->id,
            'scheduledAt' => $this->scheduledAt->format('d.m.Y H:i'),
            'patient' => sprintf(
                '%s %s',
                $this->patient->getPatient()?->getFirstName(),
                $this->patient->getPatient()?->getLastName()
            ),
            'medicalSpecialty' => $this->doctor->getMedicalSpecialty()?->getTitle(),
            'patientReason' => $this->patientReason,
        ];
    }

    public function getChecksum(): string
    {
        return md5(
            $this->id . $this->scheduledAt->getTimestamp() . $this->doctor->getDoctor()->getId() .
            $this->patient->getPatient()->getId() . $this->createdAt->getTimestamp()
        );
    }
}
