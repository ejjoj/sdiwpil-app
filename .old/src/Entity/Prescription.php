<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescriptionRepository::class)
 */
class Prescription extends AbstractEntity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=44)
     */
    private string $barcode;

    /**
     * @ORM\Column(type="string", length=38)
     */
    private string $prefixId;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private string $accessCode;

    /**
     * @ORM\Column(type="string", length=22)
     */
    private string $prescriptionFileId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $medicamentName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $medicamentDescription;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $medicamentUsageDescription;

    /**
     * @ORM\Column(type="string", length=4)
     */
    private string $medicamentRemission;

    /**
     * @ORM\OneToOne(targetEntity=Document::class, inversedBy="prescription", cascade={"persist", "remove"})
     */
    private Document $document;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getPrefixId(): ?string
    {
        return $this->prefixId;
    }

    public function setPrefixId(string $prefixId): self
    {
        $this->prefixId = $prefixId;

        return $this;
    }

    public function getAccessCode(): ?string
    {
        return $this->accessCode;
    }

    public function setAccessCode(string $accessCode): self
    {
        $this->accessCode = $accessCode;

        return $this;
    }

    public function getPrescriptionFileId(): ?string
    {
        return $this->prescriptionFileId;
    }

    public function setPrescriptionFileId(string $prescriptionFileId): self
    {
        $this->prescriptionFileId = $prescriptionFileId;

        return $this;
    }

    public function getMedicamentDescription(): ?string
    {
        return $this->medicamentDescription;
    }

    public function setMedicamentDescription(string $medicamentDescription): self
    {
        $this->medicamentDescription = $medicamentDescription;

        return $this;
    }

    public function getMedicamentName(): ?string
    {
        return $this->medicamentName;
    }

    public function setMedicamentName(string $medicamentName): self
    {
        $this->medicamentName = $medicamentName;

        return $this;
    }

    public function getMedicamentUsageDescription(): ?string
    {
        return $this->medicamentUsageDescription;
    }

    public function setMedicamentUsageDescription(string $medicamentUsageDescription): self
    {
        $this->medicamentUsageDescription = $medicamentUsageDescription;

        return $this;
    }

    public function getMedicamentRemission(): ?string
    {
        return $this->medicamentRemission;
    }

    public function setMedicamentRemission(string $medicamentRemission): self
    {
        $this->medicamentRemission = $medicamentRemission;

        return $this;
    }

    public function getDocument(): ?Document
    {
        return $this->document;
    }

    public function setDocument(Document $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function toArray(): array
    {
        $timeFormat = 'd.m.Y H:i';

        return [
            'id' => $this->id,
            'medicamentName' => $this->medicamentName,
            'medicamentDescription' => $this->medicamentDescription,
            'medicamentUsageDescription' => $this->medicamentUsageDescription,
            'medicamentRemission' => $this->medicamentRemission,
            'createdAt' => $this->createdAt->format($timeFormat),
            'updatedAt' => $this->updatedAt->format($timeFormat),
        ];
    }
}
