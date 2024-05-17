<?php

namespace App\Controller\Document;

use App\Service\Document\PrintService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloadController extends AbstractController
{
    /**
     * @Route(
     *     "/document/{hash}",
     *     name="front.document.generate",
     *     requirements={"hash"="\w+"},
     * )
     */
    public function index(string $hash, PrintService $printService): Response
    {
        return $printService->getDocumentResponse($hash);
    }
}
