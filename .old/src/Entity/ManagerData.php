<?php

namespace App\Entity;

use App\Repository\ManagerDataRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManagerDataRepository::class)
 */
class ManagerData extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="managerData", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $manager;

    /**
     * @ORM\ManyToOne(targetEntity=Clinic::class, inversedBy="managers")
     * @ORM\JoinColumn(nullable=false)
     */
    private Clinic $clinic;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

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
