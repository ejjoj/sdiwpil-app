<?php

namespace App\Service\Authorization;

use App\Exception\AccessDeniedException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

readonly class PermissionValidator
{
    public function __construct(
        private HttpClientInterface $client,
        private string $authorizationUrl,
        private TokenConverter $tokenConverter,
        private UserFlyweight $userFlyweight,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws AccessDeniedException
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function validate(?string $token): void
    {
        try {
            $response = $this->client->request(
                Request::METHOD_GET,
                $this->authorizationUrl,
                ['auth_bearer' => $this->tokenConverter->convert($token)]
            );
            $this->userFlyweight
                ->withUserPayload(json_decode($response->getContent()))
                ->setUser($token);
        } catch (ClientException) {
            throw new AccessDeniedException($this->getAccessDeniedMessage());
        }
    }

    private function getAccessDeniedMessage(): string
    {
        return $this->translator->trans('error.403');
    }
}
