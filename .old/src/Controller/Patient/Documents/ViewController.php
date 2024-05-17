<?php

namespace App\Controller\Patient\Documents;

use App\Controller\AbstractViewDocumentsListController;
use App\Service\Menu\MenuService;
use GuzzleHttp\Utils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractViewDocumentsListController
{
    /**
     * @Route("/patient/documents", name="front.patient.documents")
     */
    public function index(MenuService $menuService): Response
    {
        return $this->render('patient/documents.html.twig', [
            'state' => Utils::jsonEncode([
                'menu' => $menuService->getMenu(),
                'documents' => $this->getDocuments(),
            ]),
        ]);
    }
}
