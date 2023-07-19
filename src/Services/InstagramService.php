<?php

declare(strict_types=1);

namespace App\Services;

use App\Client\Instagram\Model\Media;
use App\Client\Instagram\Service\MediaService;
use GuzzleHttp\Exception\GuzzleException;

class InstagramService
{
    private const MAX_MEDIA_VIDEOS = 8;
    private const MAX_MEDIA_IMAGES = 8;
    private const NUMBER_OF_LAST_PUBLICATIONS = 150;
    private const FILTER_VALID_IMAGE = 'peluqueracanina ';

    private MediaService $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * @return array{
     *     publication_images: array{
     *         media_url: string,
     *         permalink: string,
     *         date: int
     *     },
     *     publication_videos: array{
     *         media_url: string,
     *         permalink: string,
     *         date: int
     *     }
     *  }
     *
     * @throws GuzzleException
     */
    public function getMedia(): array
    {
        $publicationImages = [];
        $publicationVideos = [];

        try {
            $publications = $this->mediaService->getLastPublications(self::NUMBER_OF_LAST_PUBLICATIONS);
        } catch (\Throwable $exception) {
            return [
                'publication_images' => $publicationImages,
                'publication_videos' => $publicationVideos,
            ];
        }


        if ($publications->getPublications() !== null) {
            foreach ($publications->getPublications() as $publication) {
                if ($publication->getCaption() && \stripos($publication->getCaption(), self::FILTER_VALID_IMAGE) !== false) {
                    if (($publication->getMediaType() === Media::MEDIA_TYPE_IMAGE || $publication->getMediaType() === Media::MEDIA_TYPE_CAROUSEL_ALBUM)
                        && \count($publicationImages) < self::MAX_MEDIA_IMAGES) {
                        $publicationImages[] = [
                            'media_url' => $publication->getMediaURL(),
                            'permalink' => $publication->getPermalink(),
                            'date' => $publication->getTimestamp(),
                        ];
                    }

                    if ($publication->getMediaType() === Media::MEDIA_TYPE_VIDEO && \count($publicationVideos) < self::MAX_MEDIA_VIDEOS) {
                        $publicationVideos[] = [
                            'media_url' => $publication->getMediaURL(),
                            'permalink' => $publication->getPermalink(),
                            'date' => $publication->getTimestamp(),
                        ];
                    };
                }
            }
        }

        return [
            'publication_images' => $publicationImages,
            'publication_videos' => $publicationVideos,
        ];
    }
}