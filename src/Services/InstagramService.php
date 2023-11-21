<?php

declare(strict_types=1);

namespace App\Services;

use App\Client\Instagram\Media\Factory\MediaRequestFactory;
use App\Client\Instagram\Media\Factory\PublicationResponseFactory;
use App\Client\Instagram\Media\Model\MediaResponse;
use App\Client\Instagram\Media\Model\Publications;
use App\Client\Instagram\Media\Service\MediaService;
use App\Entity\Client;
use App\Utils\Serializer;
use App\Manager\ClientManager;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Contracts\Cache\CacheInterface;

class InstagramService
{
    private const NUMBER_OF_LAST_PUBLICATIONS = 150;

    private const CACHE_KEY_INSTAGRAM_PUBLICATIONS = "instagram_publications";

    private CacheInterface $cache;

    private ClientManager $clientManager;

    public function __construct(CacheInterface $cache, ClientManager $clientManager)
    {
        $this->cache = $cache;
        $this->clientManager = $clientManager;
    }

    /**
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function getPublications(): Publications
    {
        $cachedData = $this->cache->getItem(self::CACHE_KEY_INSTAGRAM_PUBLICATIONS);

        if (!$cachedData->isHit()) {
            $client = $this->clientManager->findOneById(Client::TYPE_INSTAGRAM);
            $mediaService = new MediaService($client);

            $publicationRequest = MediaRequestFactory::build(self::NUMBER_OF_LAST_PUBLICATIONS);
            $mediaResponse = $mediaService->getMedia($publicationRequest);

            $cachedData->set(Serializer::serialize($mediaResponse, Serializer::FORMAT_JSON));
            $cachedData->expiresAfter(new \DateInterval('P1D'));
            $this->cache->save($cachedData);

            return PublicationResponseFactory::build($mediaResponse);
        }

        $mediaResponse = Serializer::deserialize($cachedData->get(), MediaResponse::class, Serializer::FORMAT_JSON);

        return PublicationResponseFactory::build($mediaResponse);
    }
}
