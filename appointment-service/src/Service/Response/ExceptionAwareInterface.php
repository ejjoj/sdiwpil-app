<?php

namespace App\Service\Response;

interface ExceptionAwareInterface
{
    public function withException(\Exception $exception): static;
}
