<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function __construct(string $environment, bool $debug)
    {
        date_default_timezone_set('Europe/Warsaw');
        parent::__construct($environment, $debug);
    }

    public function getCacheDir(): string
    {
        return '/tmp/sdiwpil/cache';
    }
}
