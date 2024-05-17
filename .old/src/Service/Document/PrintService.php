<?php

namespace App\Service\Document;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Environment;

class PrintService
{
    public const PRINT_PRESCRIPTION = 'prescription';

    private const DOCUMENT_SETTINGS = [
        self::PRINT_PRESCRIPTION => [
            'page-size' => 'A4',
            'dpi' => 300,
            'page-width' => 90,
            'page-height' => 200,
            'margin-left' => 0,
            'margin-right' => 0,
            'margin-top' => 0,
            'margin-bottom' => 0,
            'disable-smart-shrinking' => true,
            'enable-local-file-access' => true,
        ],
    ];

    public function __construct(
        private readonly Pdf $pdf,
        private readonly Environment $twig,
        private readonly EntityManagerInterface $entityManager,
        private readonly KernelInterface $kernel,
        private readonly Filesystem $filesystem
    ) {
    }

    public function getDocumentResponse(string $hash): Response
    {
        $document = $this->entityManager->getRepository(Document::class)->findOneBy(['hash' => $hash]);
        if (!$document) {
            throw new NotFoundHttpException();
        }

        return $this->getResponse($document->getType(), $this->generatePrescriptionContent($document));
    }

    private function getResponse(string $type, string $content): Response
    {
        $fileName = sprintf('%s.pdf', $type === self::PRINT_PRESCRIPTION ? 'Recepta' : 'Skierowanie');
        $response = new Response();
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="' . $fileName . '";');
        $response->headers->set('Content-length', strlen($content));
        $response->setContent($content);

        return $response;
    }

    private function removeExistingBarcodes(): void
    {
        $files = glob($this->kernel->getProjectDir() . '/tmp/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    private function getBarcode(Document $document): array
    {
        $this->createDir();
        $this->removeExistingBarcodes();
        $generator = new BarcodeGeneratorPNG();
        $barcode = $document->getPrescription()->getBarcode();
        $fileName = $this->kernel->getProjectDir() . '/tmp/' . $barcode . '.png';
        file_put_contents($fileName, $generator->getBarcode($barcode, $generator::TYPE_CODE_128));

        return [
            'file' => $fileName,
            'code' => $barcode,
        ];
    }

    private function getPrescriptionContext(Document $document): array
    {
        $patient = $document->getPatient()->getPatient();
        $doctor = $document->getDoctor()->getDoctor();

        return [
            'barcode' => $this->getBarcode($document),
            'prefix_id' => $document->getPrescription()->getPrefixId(),
            'access_code' => $document->getPrescription()->getAccessCode(),
            'created_at' => $document->getPrescription()->getCreatedAt()->format('d.m.Y'),
            'prescription_id' => $document->getPrescription()->getPrescriptionFileId(),
            'patient' => $patient->getFirstName() . ' ' . $patient->getLastName(),
            'doctor' => $doctor->getFirstName() . ' ' . $doctor->getLastName(),
            'doctor_pwz' => $document->getDoctor()->getPwzId(),
            'clinic_email' => $document->getDoctor()->getClinic()->getEmail(),
            'medicament_name' => $document->getPrescription()->getMedicamentName(),
            'medicament_description' => $document->getPrescription()->getMedicamentDescription(),
            'medicament_usage_description' => $document->getPrescription()->getMedicamentUsageDescription(),
            'medicament_remission' => $document->getPrescription()->getMedicamentRemission(),
        ];
    }

    private function generatePrescriptionContent(Document $document): string
    {
        $html = $this->twig->render('/print/prescription.html.twig', $this->getPrescriptionContext($document));

        return $this->pdf->getOutputFromHtml($html, self::DOCUMENT_SETTINGS[self::PRINT_PRESCRIPTION]);
    }

    private function createDir(): void
    {
        $tmpProjectDir = sprintf('%s/tmp/', $this->kernel->getProjectDir());
        if (!$this->filesystem->exists($tmpProjectDir)) {
            $this->filesystem->mkdir($tmpProjectDir, 0770);
        }
    }
}
