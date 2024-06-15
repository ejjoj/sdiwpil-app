<?php

namespace App\Entity;

use App\Repository\DoctorProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctorProfileRepository::class)]
class DoctorProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private string $name;

    #[ORM\Column(length: 128, nullable: true)]
    private ?string $secondName = null;

    #[ORM\Column(length: 128)]
    private string $surname;

    #[ORM\Column(length: 10, unique: true)]
    private string $npwz;

    #[ORM\Column(type: Types::JSON)]
    private array $workingTime = [];

    #[ORM\ManyToOne(inversedBy: 'doctorProfiles')]
    #[ORM\JoinColumn(nullable: false)]
    private MedicalSpecialisation $medicalSpecialisation;

    #[ORM\Column]
    private int $customerId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(?string $secondName): static
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getNpwz(): string
    {
        return $this->npwz;
    }

    public function setNpwz(string $npwz): static
    {
        $this->npwz = $npwz;

        return $this;
    }

    public function getWorkingTime(): array
    {
        return $this->workingTime;
    }

    public function setWorkingTime(array $workingTime): static
    {
        $this->workingTime = $workingTime;

        return $this;
    }

    public function getMedicalSpecialisation(): MedicalSpecialisation
    {
        return $this->medicalSpecialisation;
    }

    public function setMedicalSpecialisation(?MedicalSpecialisation $medicalSpecialisation): static
    {
        $this->medicalSpecialisation = $medicalSpecialisation;

        return $this;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): static
    {
        $this->customerId = $customerId;

        return $this;
    }
}
