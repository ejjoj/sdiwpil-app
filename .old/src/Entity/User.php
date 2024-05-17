<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_PATIENT = 'ROLE_PATIENT';
    public const ROLE_DOCTOR = 'ROLE_DOCTOR';
    public const ROLE_RECEPTIONIST = 'ROLE_RECEPTIONIST';
    public const ROLE_MANAGER = 'ROLE_MANAGER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="json")
     */
    private array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\OneToOne(targetEntity=PatientData::class, mappedBy="patient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?PatientData $patientData;

    /**
     * @ORM\OneToOne(targetEntity=DoctorData::class, mappedBy="doctor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?DoctorData $doctorData;

    /**
     * @ORM\OneToOne(targetEntity=ReceptionistData::class, mappedBy="receptionist", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?ReceptionistData $receptionistData;

    /**
     * @ORM\OneToOne(targetEntity=ManagerData::class, mappedBy="manager", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?ManagerData $managerData;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender")
     */
    private Collection $messages;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private string $secondName;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private string $lastName;

    public function __construct()
    {
        parent::__construct();
        $this->messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPatientData(): ?PatientData
    {
        return $this->patientData;
    }

    public function setPatientData(?PatientData $patientData): self
    {
        // unset the owning side of the relation if necessary
        if ($patientData === null && $this->patientData !== null) {
            $this->patientData->setPatient(null);
        }

        // set the owning side of the relation if necessary
        if ($patientData !== null && $patientData->getPatient() !== $this) {
            $patientData->setPatient($this);
        }

        $this->patientData = $patientData;

        return $this;
    }

    public function getDoctorData(): ?DoctorData
    {
        return $this->doctorData;
    }

    public function setDoctorData(?DoctorData $doctorData): self
    {
        // unset the owning side of the relation if necessary
        if ($doctorData === null && $this->doctorData !== null) {
            $this->doctorData->setDoctor(null);
        }

        // set the owning side of the relation if necessary
        if ($doctorData !== null && $doctorData->getDoctor() !== $this) {
            $doctorData->setDoctor($this);
        }

        $this->doctorData = $doctorData;

        return $this;
    }

    public function getReceptionistData(): ?ReceptionistData
    {
        return $this->receptionistData;
    }

    public function setReceptionistData(?ReceptionistData $receptionistData): self
    {
        // unset the owning side of the relation if necessary
        if ($receptionistData === null && $this->receptionistData !== null) {
            $this->receptionistData->setReceptionist(null);
        }

        // set the owning side of the relation if necessary
        if ($receptionistData !== null && $receptionistData->getReceptionist() !== $this) {
            $receptionistData->setReceptionist($this);
        }

        $this->receptionistData = $receptionistData;

        return $this;
    }

    public function getManagerData(): ?ManagerData
    {
        return $this->managerData;
    }

    public function setManagerData(?ManagerData $managerData): self
    {
        // unset the owning side of the relation if necessary
        if ($managerData === null && $this->managerData !== null) {
            $this->managerData->setManager(null);
        }

        // set the owning side of the relation if necessary
        if ($managerData !== null && $managerData->getManager() !== $this) {
            $managerData->setManager($this);
        }

        $this->managerData = $managerData;

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
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        // set the owning side to null (unless already changed)
        if ($this->messages->removeElement($message) && $message->getSender() === $this) {
            $message->setSender(null);
        }

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(?string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'doctorData' => $this->doctorData ? $this->doctorData->toArray() : null,
            'firstName' => $this->firstName,
            'secondName' => $this->secondName,
            'lastName' => $this->lastName,
        ];
    }
}
