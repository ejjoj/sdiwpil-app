<?php

namespace App\Entity;

use App\Repository\ClinicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClinicRepository::class)
 */
class Clinic extends AbstractEntity implements FrontEndStructureEntityInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=75)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=90)
     */
    private string $country;

    /**
     * @ORM\Column(type="string", length=189)
     */
    private string $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=18)
     */
    private string $zipCode;

    /**
     * @ORM\Column(type="string", length=95)
     */
    private string $streetAddress;

    /**
     * @ORM\ManyToMany(targetEntity=\App\Entity\DoctorData::class, inversedBy="clinics")
     */
    private Collection $doctors;

    /**
     * @ORM\OneToMany(targetEntity=ReceptionistData::class, mappedBy="clinic")
     */
    private Collection $receptionists;

    /**
     * @ORM\OneToMany(targetEntity=ManagerData::class, mappedBy="clinic")
     */
    private Collection $managers;

    public function __construct()
    {
        parent::__construct();

        $this->doctors = new ArrayCollection();
        $this->receptionists = new ArrayCollection();
        $this->managers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * @return Collection|DoctorData[]
     */
    public function getDoctors(): Collection
    {
        return $this->doctors;
    }

    public function addDoctor(DoctorData $doctor): self
    {
        if (!$this->doctors->contains($doctor)) {
            $this->doctors[] = $doctor;
        }

        return $this;
    }

    public function removeDoctor(DoctorData $doctor): self
    {
        $this->doctors->removeElement($doctor);

        return $this;
    }

    /**
     * @return Collection|ReceptionistData[]
     */
    public function getReceptionists(): Collection
    {
        return $this->receptionists;
    }

    public function addReceptionist(ReceptionistData $receptionist): self
    {
        if (!$this->receptionists->contains($receptionist)) {
            $this->receptionists[] = $receptionist;
            $receptionist->setClinic($this);
        }

        return $this;
    }

    public function removeReceptionist(ReceptionistData $receptionist): self
    {
        // set the owning side to null (unless already changed)
        if ($this->receptionists->removeElement($receptionist) && $receptionist->getClinic() === $this) {
            $receptionist->setClinic(null);
        }

        return $this;
    }

    /**
     * @return Collection|ManagerData[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(ManagerData $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setClinic($this);
        }

        return $this;
    }

    public function removeManager(ManagerData $manager): self
    {
        // set the owning side to null (unless already changed)
        if ($this->managers->removeElement($manager) && $manager->getClinic() === $this) {
            $manager->setClinic(null);
        }

        return $this;
    }

    public function toFrontEndArray(): array
    {
        return [
            'text' => sprintf('%s/%s/%s/%s', $this->name, $this->city, $this->streetAddress, $this->zipCode),
            'value' => $this->id,
        ];
    }
}
