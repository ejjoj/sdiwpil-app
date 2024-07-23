<?php

namespace App\Service\ExternalEntity\Flyweight;

use App\Model\ExternalEntity\AbstractExternalEntityModel;
use App\Service\ExternalEntity\Repository\AbstractRepository;

abstract class AbstractFlyweight
{
    private array $objects = [];

    public function __construct(private readonly AbstractRepository $repository)
    {
    }

    public function get(int $id): ?AbstractExternalEntityModel
    {
        if (isset($this->objects[$id])) {
            return $this->objects[$id];
        }

        return $this->objects[$id] = $this->repository->find($id);
    }
}
