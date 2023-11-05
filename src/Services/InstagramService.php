<?php

declare(strict_types=1);

namespace App\Services;

use App\Client\Instagram\Media\Factory\PublicationRequestFactory;
use App\Client\Instagram\Media\Factory\PublicationResponseFactory;
use App\Client\Instagram\Media\Model\MediaResponse;
use App\Client\Instagram\Media\Model\Publications;
use App\Client\Instagram\Media\Service\MediaService;
use App\Helper\Serializer;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Contracts\Cache\CacheInterface;

class InstagramService
{
    private const NUMBER_OF_LAST_PUBLICATIONS = 150;

    private const CACHE_KEY_INSTAGRAM_PUBLICATIONS = "instagram_publications";

    private MediaService $mediaService;

    private CacheInterface $cache;

    public function __construct(MediaService $mediaService, CacheInterface $cache)
    {
        $this->mediaService = $mediaService;
        $this->cache = $cache;
    }

    /**
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function getPublications(): Publications
    {
        $cachedData = $this->cache->getItem(self::CACHE_KEY_INSTAGRAM_PUBLICATIONS);

        if (!$cachedData->isHit()) {
            $publicationRequest = PublicationRequestFactory::build(self::NUMBER_OF_LAST_PUBLICATIONS);
            $mediaResponse = $this->mediaService->getMedia($publicationRequest);
            $cachedData->set(Serializer::serialize($mediaResponse, Serializer::FORMAT_JSON));
            $cachedData->expiresAfter(new \DateInterval('P1D'));
            $this->cache->save($cachedData);

            return PublicationResponseFactory::build($mediaResponse);
        }

        $mediaResponse = Serializer::deserialize($cachedData->get(), MediaResponse::class, Serializer::FORMAT_JSON);

        return PublicationResponseFactory::build($mediaResponse);
    }
}
