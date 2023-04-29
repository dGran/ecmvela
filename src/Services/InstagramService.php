<?php

declare(strict_types=1);

namespace App\Services;

use App\Helper\Serializer;
use App\Model\Instagram\Publications;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class InstagramService
{
    public const BASE_URI = "https://graph.instagram.com";
    public const MEDIA_ENDPOINT = "/me/media";
    public const MEDIA_FIELDS = "id,caption,media_type,media_url";
    public const DEFAULT_LIMIT = 10;

    /**
     * @throws GuzzleException
     */
    public function getLastPublications(?int $limit = self::DEFAULT_LIMIT): Publications
    {
        $accessToken = $_ENV['INSTAGRAM_ACCESS_TOKEN'];

        $client = new Client();

        try {
            $response = $client->request('GET', self::BASE_URI.self::MEDIA_ENDPOINT.'?fields='.self::MEDIA_FIELDS.'&access_token='.$accessToken.'&limit='.$limit);
        } catch (\Exception $exception) {

        }

        $statusCode = $response->getStatusCode();
        $responseBodyContents = $response->getBody()->getContents();

        return Serializer::deserialize($responseBodyContents, Publications::class, Serializer::FORMAT_JSON);
    }
}