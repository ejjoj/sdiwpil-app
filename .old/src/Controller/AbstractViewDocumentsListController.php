<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\User;
use App\Service\Document\DocumentFrontEndStructureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractViewDocumentsListController extends AbstractController
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        private readonly DocumentFrontEndStructureService $documentFrontEndStructureService,
    ) {
    }

    protected function getDocuments(): array
    {
        /** @var User $user */
        $user = $this->getUser();

        return $this->documentFrontEndStructureService->getFrontEndStructure(
            $this->entityManager->getRepository(Document::class)->getPaginatedDocuments(
                ['min' => 0, 'max' => 25],
                $user->getDoctorData(),
                $user->getPatientData(),
            )
        );
    }
}
