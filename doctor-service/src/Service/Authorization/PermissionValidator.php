<?php

namespace App\Service\Authorization;

use App\Exception\AccessDeniedException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class PermissionValidator
{
    public function __construct(private HttpClientInterface $client, private string $authorizationUrl)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws AccessDeniedException
     */
    public function validate(?string $token): void
    {
        try {
            $preparedToken = $this->prepareToken($token);
            $this->client->request(
                Request::METHOD_POST,
                $this->authorizationUrl,
                ['auth_bearer' => $preparedToken]
            );
        } catch (ClientException $exception) {
            throw new AccessDeniedException();
        }
    }

    private function prepareToken(?string $token): string
    {
        if (!$token) {
            return '';
        }

        return str_replace('Bearer ', '', $token);
    }
}
