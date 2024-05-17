<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Utils;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Document extends AbstractEntity
{
    public const PRESCRIPTION_TYPE = 'prescription';
    public const SICK_LEAVE_TYPE = 'sick_leave';
    public const REFERRAL_TYPE = 'referral';

    public const ALLOWED_TYPES = [
        self::PRESCRIPTION_TYPE,
        self::SICK_LEAVE_TYPE,
        self::REFERRAL_TYPE,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private string $type;

    /**
     * @ORM\ManyToOne(targetEntity=DoctorData::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private DoctorData $doctor;

    /**
     * @ORM\ManyToOne(targetEntity=PatientData::class, inversedBy="documents")
     * @ORM\JoinColumn(nullable=false)
     */
    private PatientData $patient;

    /**
     * @ORM\OneToOne(targetEntity=Prescription::class, mappedBy="document", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Prescription $prescription = null;

    /**
     * @ORM\Column(type="string", length=32, nullable=false, unique=true)
     */
    private string $hash;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, self::ALLOWED_TYPES)) {
            throw new \RuntimeException('Given type is not allowed');
        }

        $this->type = $type;

        return $this;
    }

    public function getDoctor(): ?DoctorData
    {
        return $this->doctor;
    }

    public function setDoctor(?DoctorData $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getPatient(): ?PatientData
    {
        return $this->patient;
    }

    public function setPatient(?PatientData $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getPrescription(): ?Prescription
    {
        return $this->prescription;
    }

    public function setPrescription(?Prescription $prescription): self
    {
        // unset the owning side of the relation if necessary
        if ($prescription === null && $this->prescription !== null) {
            $this->prescription->setDocument(null);
        }

        // set the owning side of the relation if necessary
        if ($prescription !== null && $prescription->getDocument() !== $this) {
            $prescription->setDocument($this);
        }

        $this->prescription = $prescription;

        return $this;
    }

    public function toArray(): array
    {
        $doctor = $this->doctor->getDoctor();
        $patient = $this->patient->getPatient();
        $dateFormat = 'd.m.Y';

        return [
            'id' => $this->id,
            'type' => $this->type,
            'doctor' => $doctor->getFirstName() . ' ' . $doctor->getLastName(),
            'patient' => $patient->getFirstName() . ' ' . $patient->getLastName(),
            'prescription' => $this->prescription ? $this->prescription->toArray() : [],
            'createdAt' => $this->createdAt->format($dateFormat),
            'updatedAt' => $this->updatedAt->format($dateFormat),
            'hash' => $this->hash,
        ];
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): Document
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function saveHash(): void
    {
        $doctor = $this->doctor->getDoctor();
        $patient = $this->patient->getPatient();

        $this->hash = md5(Utils::jsonEncode([
            'type' => $this->type,
            'doctor' => $doctor->getFirstName() . ' ' . $doctor->getLastName(),
            'patient' => $patient->getFirstName() . ' ' . $patient->getLastName(),
            'prescription' => $this->prescription ? $this->prescription->toArray() : [],
            'createdAt' => $this->createdAt->format('YmdHis'),
            'updatedAt' => $this->updatedAt->format('YmdHis'),
        ]));
    }
}
