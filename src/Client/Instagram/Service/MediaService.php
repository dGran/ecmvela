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
    public const MEDIA_ENDPOINT = "/me/media";
    public const MEDIA_FIELDS = "id,caption,media_type,media_url,permalink,timestamp";

    public function __construct(private readonly LoggerInterface $logger)
    {
        parent::__construct();
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
            self::BASE_URI.self::MEDIA_ENDPOINT.'?fields='.self::MEDIA_FIELDS.'&access_token='.$this->accessToken.'&limit='.$limit
        );
        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            $responseBodyContents = $response->getBody()->getContents();

            return Serializer::deserialize($responseBodyContents, Publications::class, Serializer::FORMAT_JSON);
        }

        $this->logger->critical('Invalid status code from instagram API, status code: '.$statusCode);

        return new Publications();
    }
}