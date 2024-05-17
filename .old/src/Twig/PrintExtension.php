<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PrintExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_environment', [$this, 'getEnvironment']),
        ];
    }

    public function getEnvironment(): string
    {
        return $_ENV['APP_ENV'];
    }
}
