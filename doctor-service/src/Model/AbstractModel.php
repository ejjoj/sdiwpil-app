<?php

namespace App\Model;

abstract class AbstractModel
{
    protected array $data = [];

    public function toArray(): array
    {
        return $this->recursiveToArray($this->data);
    }

    private function recursiveToArray($data)
    {
        if (is_array($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = $this->recursiveToArray($value);
            }
            return $result;
        } elseif ($data instanceof AbstractModel) {
            return $data->toArray();
        } else {
            return $data;
        }
    }
}
