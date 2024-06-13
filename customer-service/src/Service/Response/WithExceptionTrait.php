<?php

namespace App\Service\Response;

trait WithExceptionTrait
{
    protected \Exception $exception;

    public function withException(\Exception $exception): static
    {
        $this->exception = $exception;

        return $this;
    }
}
