<?php

namespace App\Service\Entity\Appointment\WorkingTimeResolver;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class DefaultWorkingHoursResolver implements WorkingHoursResolverInterface
{
    public function __construct(
      private HttpClientInterface $client,
      private string $getWorkingHoursUrl,
    ) {
    }

    public function resolve(int $doctorProfileId): array
    {
        try {
            $response = $this->client->request(
                Request::METHOD_GET,
                $this->convertUrl($doctorProfileId),
            );

            return json_decode($response->getContent() ?: '{}', true)['workingHours'] ?? [];
        } catch (
            TransportExceptionInterface
            | ClientExceptionInterface
            | RedirectionExceptionInterface
            | ServerExceptionInterface
        ) {
            return [];
        }
    }

    private function convertUrl(int $doctorProfileId): string
    {
        return str_replace('{id}', $doctorProfileId, $this->getWorkingHoursUrl);
    }
}
