<?php

declare(strict_types=1);

namespace App\Client\Instagram\Service;

use App\Client\Instagram\Model\Publications;
use App\Helper\Serializer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class MediaService extends BaseService
{
    private const MEDIA_ENDPOINT = "/me/media";

    private const MEDIA_FIELDS = [
        'id',
        'caption',
        'media_type',
        'media_url',
        'permalink',
        'timestamp',
    ];

    private const MEDIA_FIELDS_SEPARATOR = ',';

    private string $mediaFields;

    public function __construct(private readonly LoggerInterface $logger)
    {
        parent::__construct();

        $this->mediaFields = \implode(self::MEDIA_FIELDS_SEPARATOR, self::MEDIA_FIELDS);
    }

    /**
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getLastPublications(int $limit): Publications
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            self::BASE_URI.self::MEDIA_ENDPOINT.'?fields='.$this->mediaFields.'&access_token='.$this->accessToken.'&limit='.$limit
        );
        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            $responseBodyContents = $response->getBody()->getContents();

            return Serializer::deserialize($responseBodyContents, Publications::class, Serializer::FORMAT_JSON);
        }

        $this->logger->critical(\DATE_W3C.' - '.__METHOD__.' - Invalid status code from instagram API, status code: '.$statusCode);

        return new Publications();
    }
}