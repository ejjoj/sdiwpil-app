<?php

namespace App\Service\ExternalEntity\Converter;

use App\Model\ExternalEntity\AbstractExternalEntityModel;

abstract class AbstractExternalEntityConverter
{
    protected array $rawResponse;

    abstract public function convert(): AbstractExternalEntityModel;

    public function withRawResponse(array $rawResponse): static
    {
        $this->rawResponse = $rawResponse;

        return $this;
    }
}
