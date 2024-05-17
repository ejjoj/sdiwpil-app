<?php

namespace App\Entity;

use App\Repository\PatientDataRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientDataRepository::class)
 */
class PatientData extends AbstractEntity
{
    public const GENDER_FEMALE = 'female';
    public const GENDER_MALE = 'male';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="patientData", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $patient;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="patient")
     */
    private Collection $documents;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="patient")
     */
    private Collection $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Conversation::class, mappedBy="patient")
     */
    private Collection $conversations;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private string $pesel;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private string $gender;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $bornAt;

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

    public function getPatient(): ?User
    {
        return $this->patient;
    }

    public function setPatient(?User $patient): self
    {
        $this->patient = $patient;

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
            $document->setPatient($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        // set the owning side to null (unless already changed)
        if ($this->documents->removeElement($document) && $document->getPatient() === $this) {
            $document->setPatient(null);
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
            $appointment->setPatient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        // set the owning side to null (unless already changed)
        if ($this->appointments->removeElement($appointment) && $appointment->getPatient() === $this) {
            $appointment->setPatient(null);
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
            $conversation->setPatient($this);
        }

        return $this;
    }

    public function removeConversation(Conversation $conversation): self
    {
        // set the owning side to null (unless already changed)
        if ($this->conversations->removeElement($conversation) && $conversation->getPatient() === $this) {
            $conversation->setPatient(null);
        }

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(string $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBornAt(): ?DateTimeImmutable
    {
        return $this->bornAt;
    }

    public function setBornAt(DateTimeImmutable $bornAt): self
    {
        $this->bornAt = $bornAt;

        return $this;
    }
}
