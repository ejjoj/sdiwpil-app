<?php

namespace App\Entity;

use App\Repository\ReceptionistDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReceptionistDataRepository::class)
 */
class ReceptionistData extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="receptionistData", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $receptionist;

    /**
     * @ORM\ManyToOne(targetEntity=Clinic::class, inversedBy="receptionists")
     * @ORM\JoinColumn(nullable=false)
     */
    private Clinic $clinic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceptionist(): ?User
    {
        return $this->receptionist;
    }

    public function setReceptionist(?User $receptionist): self
    {
        $this->receptionist = $receptionist;

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
}
