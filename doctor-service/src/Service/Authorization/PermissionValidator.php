<?php

namespace App\Service\Authorization;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PermissionValidator
{
    public function __construct(private readonly HttpClientInterface $client)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function validate(?string $token): void
    {
        $preparedToken = $this->prepareToken($token);
        $this->client->request(
            Request::METHOD_POST,
            'http://customer-service:8000/login',
            ['auth_bearer' => $preparedToken]
        );
    }

    private function prepareToken(?string $token): string
    {
        if (!$token) {
            return '';
        }

        return str_replace('Bearer ', '', $token);
    }
}
