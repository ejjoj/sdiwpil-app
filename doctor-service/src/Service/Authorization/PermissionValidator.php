<?php

namespace App\Service\Authorization;

use App\Exception\AccessDeniedException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class PermissionValidator
{
    public function __construct(
        private HttpClientInterface $client,
        private string $authorizationUrl,
        private TokenConverter $tokenConverter,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws AccessDeniedException
     */
    public function validate(?string $token): void
    {
        try {
            $this->client->request(
                Request::METHOD_GET,
                $this->authorizationUrl,
                ['auth_bearer' => $this->tokenConverter->convert($token)]
            );
        } catch (ClientException) {
            throw new AccessDeniedException();
        }
    }
}
