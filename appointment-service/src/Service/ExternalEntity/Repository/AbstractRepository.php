<?php

namespace App\Service\ExternalEntity\Repository;

use App\Model\ExternalEntity\AbstractExternalEntityModel;
use App\Service\ExternalEntity\Converter\AbstractExternalEntityConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use function Sentry\captureException;

abstract readonly class AbstractRepository
{
    public function __construct(
        private HttpClientInterface $client,
        private string $endpointUrl,
        private AbstractExternalEntityConverter $converter,
    ) {
    }

    public function find(int $id): ?AbstractExternalEntityModel
    {
        try {
            $response = $this->getResponse($id);
            $profile = json_decode($response->getContent(), true);
            $profile = $this->converter->withRawResponse($profile)->convert();
        } catch (ClientExceptionInterface) {
            $profile = null;
        } catch (
        TransportExceptionInterface
        | RedirectionExceptionInterface
        | ServerExceptionInterface $exception
        ) {
            captureException($exception);
            $profile = null;
        } finally {
            return $profile;
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getResponse(int $id): ResponseInterface
    {
        return $this->client->request(
            Request::METHOD_GET,
            $this->convertUrl($id),
        );
    }

    protected function convertUrl(int $id): string
    {
        return str_replace('{id}', $id, $this->endpointUrl);
    }
}
