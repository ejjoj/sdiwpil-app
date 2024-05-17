<?php

namespace App\Controller\Document;

use App\Service\Document\EditDocumentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @Route(
     *     "/document-edit",
     *     name="front.document.edit",
     *     methods={"POST"}
     * )
     */
    public function index(EditDocumentService $editDocumentService): JsonResponse
    {
        return $editDocumentService->getJsonResponse();
    }
}
