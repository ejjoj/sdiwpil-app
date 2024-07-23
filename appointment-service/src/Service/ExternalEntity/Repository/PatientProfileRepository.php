<?php

namespace App\Service\ExternalEntity\Repository;

use App\Service\ExternalEntity\Converter\PatientProfileConverter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class PatientProfileRepository extends AbstractRepository
{
    public function __construct(
        HttpClientInterface $client,
        string $endpointUrl,
        PatientProfileConverter $converter,
    ) {
        parent::__construct($client, $endpointUrl, $converter);
    }
}
