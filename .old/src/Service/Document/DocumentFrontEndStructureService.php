<?php

namespace App\Service\Document;

use App\Entity\Document;

class DocumentFrontEndStructureService
{
    /**
     * @param mixed|Document[] $documents
     */
    public function getFrontEndStructure($documents): array
    {
        foreach ($documents as $document) {
            $tmpDocument = $document->toArray();
            $tmpDocument['type'] = $this->getFrontEndType($document);
            $result[] = $tmpDocument;
        }

        return $result ?? [];
    }

    private function getFrontEndType(Document $document): string
    {
        $type = $document->getType();
        if ($type === Document::PRESCRIPTION_TYPE) {
            return 'recepta';
        }

        return $type;
    }
}
