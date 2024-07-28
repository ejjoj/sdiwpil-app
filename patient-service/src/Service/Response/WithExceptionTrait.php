<?php

namespace App\Service\Response;

trait WithExceptionTrait
{
    protected \Throwable $exception;

    public function withException(\Throwable $exception): static
    {
        $this->exception = $exception;

        return $this;
    }
}
