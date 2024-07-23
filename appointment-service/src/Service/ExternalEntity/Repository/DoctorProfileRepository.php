<?php

namespace App\Service\ExternalEntity\Repository;

use App\Service\ExternalEntity\Converter\DoctorProfileConverter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class DoctorProfileRepository extends AbstractRepository
{
    public function __construct(
        HttpClientInterface $client,
        string $endpointUrl,
        DoctorProfileConverter $converter
    ) {
        parent::__construct($client, $endpointUrl, $converter);
    }
}
