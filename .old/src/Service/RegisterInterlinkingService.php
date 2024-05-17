<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegisterInterlinkingService
{
    private const ROUTE = 'route';
    private const NAME = 'name';
    private const COLOR = 'color';
    private const ROUTE_NAME_TO_PARAMS_MAPPING = [
        'front.patient.register' => [
            'title' => 'Zarejestruj się jako pacjent',
            'color' => '#00CEC8',
        ],
        'front.doctor.register' => [
            'title' => 'Zarejestruj się jako lekarz',
            'color' => '#35A6E6',
        ],
    ];

    public function __construct(private readonly UrlGeneratorInterface $router)
    {
    }

    public function get(string $name = ''): array
    {
        foreach (self::ROUTE_NAME_TO_PARAMS_MAPPING as $routeName => $params) {
            if ($name !== $routeName) {
                $result[] = $this->getInterlink($routeName, $params);
            }
        }

        return $result ?? [];
    }

    #[ArrayShape([
        self::NAME => "string",
        self::ROUTE => "string",
        self::COLOR => "string"
    ])] private function getInterlink(string $name, array $params): array
    {
        return [
            self::NAME => $params['title'],
            self::ROUTE => $this->router->generate($name),
            self::COLOR => $params['color'],
        ];
    }
}
