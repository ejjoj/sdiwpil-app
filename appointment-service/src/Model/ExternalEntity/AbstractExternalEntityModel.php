<?php

namespace App\Model\ExternalEntity;

use App\Model\AbstractModel;

abstract class AbstractExternalEntityModel extends AbstractModel
{
    public function setId(int $id): static
    {
        $this->data['id'] = $id;

        return $this;
    }
}
