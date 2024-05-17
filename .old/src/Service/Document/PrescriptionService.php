<?php

namespace App\Service\Document;

use App\Entity\Document;
use App\Entity\Prescription;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class PrescriptionService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws Exception
     */
    public function createPrescription(array $documentData): void
    {
        $document = $this->createDocument($documentData);
        $this->entityManager->persist($document);

        $prescription = (new Prescription())
            ->setBarcode($this->getBarcode())
            ->setPrefixId($this->getPrefixId())
            ->setAccessCode($this->getAccessCode())
            ->setPrescriptionFileId($this->getPrescriptionFileId())
            ->setMedicamentName($documentData['medicamentName'])
            ->setMedicamentDescription($documentData['medicamentDescription'])
            ->setMedicamentUsageDescription($documentData['medicamentUsageDescription'])
            ->setMedicamentRemission($documentData['medicamentRemission'])
            ->setDocument($document);

        $document->setPrescription($prescription);

        $this->entityManager->persist($prescription);
        $this->entityManager->persist($document);
        $this->entityManager->flush();
    }

    private function createDocument(array $documentData): Document
    {
        return (new Document())
            ->setType($documentData['type'])
            ->setDoctor($documentData['doctor'])
            ->setPatient($documentData['patient']);
    }

    private function getBarcode(): string
    {
        $alphabet = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $result = '';
        for ($i = 0; $i < 44; $i++) {
            $result .= $alphabet[array_rand($alphabet)];
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    private function getPrefixId(): string
    {
        $mapping = [
            [0, 9],
            [10, 99],
            [100, 999],
            [0, 9],
            [100000, 999999],
            [0, 9],
            [1000, 9999],
            [0, 9],
            [0, 9],
            [10000, 99999],
            [0, 9],
            [0, 9],
        ];

        $result = '';
        foreach ($mapping as $i => $rangeArray) {
            $result .= random_int($rangeArray[0], $rangeArray[1]);
            if ($i !== 11) {
                $result .= '.';
            }
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    private function getAccessCode(): string
    {
        return random_int(1000, 9999);
    }

    /**
     * @throws Exception
     */
    private function getPrescriptionFileId(): string
    {
        $alphabet = 'qwertyuiopasdfghjklzxcvbnm';
        $randomLetters = '';
        for ($i = 0; $i < 2; $i++) {
            $randomLetters .= $alphabet[random_int(0, 25)];
        }

        return sprintf(
            '%s%s%s',
            random_int(1000000000, 9999999999),
            $randomLetters,
            random_int(1000000000, 9999999999)
        );
    }
}
