<?php

namespace App\Model;

abstract class AbstractModel
{
    protected array $data = [];

    public function toArray(): array
    {
        foreach ($this->data as $key => $value) {
            if ($value instanceof AbstractModel) {
                $result[$key] = $value->toArray();
            } else {
                $result[$key] = $value;
            }
        }

        return $result ?? [];
    }
}
