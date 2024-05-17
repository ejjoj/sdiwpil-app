<?php

namespace App\Entity;

use App\Repository\DoctorDataRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DoctorDataRepository::class)
 */
class DoctorData extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="doctorData", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private User $doctor;

    /**
     * @ORM\ManyToOne(targetEntity=Clinic::class, inversedBy="doctor")
     */
    private Clinic $clinic;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="doctor", orphanRemoval=true)
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="doctor", orphanRemoval=true)
     */
    private Collection $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="doctor")
     */
    private Collection $conversations;

    /**
     * @ORM\ManyToOne(targetEntity=MedicalSpecialty::class, inversedBy="doctors")
     * @ORM\JoinColumn(nullable=false)
     */
    private MedicalSpecialty $medicalSpecialty;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $workingTime = [];

    /**
     * @ORM\Column(type="string", length=7, unique=true)
     */
    private string $pwzId;

    public function __construct()
    {
        parent::__construct();

        $this->documents = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->conversations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    public function setDoctor(?User $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getClinic(): ?Clinic
    {
        return $this->clinic;
    }

    public function setClinic(?Clinic $clinic): self
    {
        $this->clinic = $clinic;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setDoctor($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        // set the owning side to null (unless already changed)
        if ($this->documents->removeElement($document) && $document->getDoctor() === $this) {
            $document->setDoctor(null);
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setDoctor($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        // set the owning side to null (unless already changed)
        if ($this->appointments->removeElement($appointment) && $appointment->getDoctor() === $this) {
            $appointment->setDoctor(null);
        }

        return $this;
    }

    /**
     * @return Collection|Conversation[]
     */
    public function getConversations(): Collection
    {
        return $this->conversations;
    }

    public function addConversation(Conversation $conversation): self
    {
        if (!$this->conversations->contains($conversation)) {
            $this->conversations[] = $conversation;
            $conversation->setDoctor($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        // set the owning side to null (unless already changed)
        if ($this->conversations->removeElement($conversation) && $conversation->getDoctor() === $this) {
            $conversation->setDoctor(null);
        }

        return $this;
    }

    public function getMedicalSpecialty(): ?MedicalSpecialty
    {
        return $this->medicalSpecialty;
    }

    public function setMedicalSpecialty(MedicalSpecialty $medicalSpecialty): self
    {
        $this->medicalSpecialty = $medicalSpecialty;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'medicalSpecialty' => $this->medicalSpecialty->toArray(),
        ];
    }

    public function getWorkingTime(): ?array
    {
        return $this->workingTime;
    }

    public function setWorkingTime(?array $workingTime): self
    {
        $this->workingTime = $workingTime;

        return $this;
    }

    public function getPwzId(): ?string
    {
        return $this->pwzId;
    }

    public function setPwzId(string $pwzId): self
    {
        $this->pwzId = $pwzId;

        return $this;
    }
}
