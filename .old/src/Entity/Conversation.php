<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConversationRepository::class)
 */
class Conversation extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private string $title;

    /**
     * @ORM\ManyToOne(targetEntity=PatientData::class, inversedBy="conversations")
     * @ORM\JoinColumn(nullable=false)
     */
    private PatientData $patient;

    /**
     * @ORM\ManyToOne(targetEntity=DoctorData::class, inversedBy="conversations")
     * @ORM\JoinColumn(nullable=false)
     */
    private DoctorData $doctor;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private string $channelId;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="conversation")
     */
    private Collection $messages;

    public function __construct()
    {
        parent::__construct();

        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getDoctor(): ?DoctorData
    {
        return $this->doctor;
    }

    public function setDoctor(?DoctorData $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getChannelId(): ?string
    {
        return $this->channelId;
    }

    public function setChannelId(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversation($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        // set the owning side to null (unless already changed)
        if ($this->messages->removeElement($message) && $message->getConversation() === $this) {
            $message->setConversation(null);
        }

        return $this;
    }

    public function toArray(): array
    {
        $format = '%s %s';
        $patient = $this->patient->getPatient();
        $doctor = $this->doctor->getDoctor();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'patient' => sprintf($format, $patient->getFirstName(), $patient->getLastName()),
            'doctor' => sprintf($format, $doctor->getFirstName(), $doctor->getLastName()),
            'channelId' => $this->channelId,
            'createdAt' => $this->createdAt->format('d.m.Y H:i'),
        ];
    }
}
