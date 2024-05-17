<?php

namespace App\Entity;

use App\Repository\MedicalSpecialtyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicalSpecialtyRepository::class)
 */
class MedicalSpecialty implements FrontEndStructureEntityInterface
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
    private string $title;

    /**
     * @ORM\OneToMany(targetEntity=DoctorData::class, mappedBy="medicalSpecialty")
     */
    private Collection $doctors;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    public function __construct()
    {
        $this->doctors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $doctor->setMedicalSpecialty($this);
        }

        return $this;
    }

    public function removeDoctor(DoctorData $doctor): self
    {
        // set the owning side to null (unless already changed)
        if ($this->doctors->removeElement($doctor) && $doctor->getMedicalSpecialty() === $this) {
            $doctor->setMedicalSpecialty(null);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function toFrontEndArray(): array
    {
        return [
            'text' => $this->title,
            'value' => $this->id,
        ];
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
