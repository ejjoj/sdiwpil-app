<?php

namespace App\Entity;

use App\Repository\MedicalSpecialisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MedicalSpecialisationRepository::class)]
class MedicalSpecialisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    /**
     * @var Collection<int, DoctorProfile>
     */
    #[ORM\OneToMany(targetEntity: DoctorProfile::class, mappedBy: 'medicalSpecialisation')]
    private Collection $doctorProfiles;

    public function __construct()
    {
        $this->doctorProfiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, DoctorProfile>
     */
    public function getDoctorProfiles(): Collection
    {
        return $this->doctorProfiles;
    }

    public function addDoctorProfile(DoctorProfile $doctorProfile): static
    {
        if (!$this->doctorProfiles->contains($doctorProfile)) {
            $this->doctorProfiles->add($doctorProfile);
            $doctorProfile->setMedicalSpecialisation($this);
        }

        return $this;
    }

    public function removeDoctorProfile(DoctorProfile $doctorProfile): static
    {
        if (
            $this->doctorProfiles->removeElement($doctorProfile)
            && $doctorProfile->getMedicalSpecialisation() === $this
        ) {
            // set the owning side to null (unless already changed)
            $doctorProfile->setMedicalSpecialisation(null);
        }

        return $this;
    }
}
