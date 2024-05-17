<?php

namespace App\Controller\Patient\Documents;

use App\Service\Document\DocumentListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route(
     *     "/patient/documents/list",
     *     name="front.patient.documents.list",
     *     methods={"GET"},
     * )
     */
    public function __invoke(DocumentListService $documentListService): JsonResponse
    {
        return $documentListService->getJsonResponse();
    }
}
