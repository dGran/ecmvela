<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Factory;

use App\Client\Instagram\Media\Enums\MediaTypes;
use App\Client\Instagram\Media\Model\MediaItem;
use App\Client\Instagram\Media\Model\MediaResponse;
use App\Client\Instagram\Media\Model\Publications;

class PublicationResponseFactory
{
    private const MAX_MEDIA_VIDEOS = 8;

    private const MAX_MEDIA_IMAGES = 8;

    private const FILTER_VALID_IMAGE = ['#peluqueracanina', '#peluqueriacanina', '#peluqueríacanina'];

    public static function build(MediaResponse $mediaResponse): Publications
    {
        $publications = new Publications();

        if (empty($mediaResponse->data)) {
            return $publications;
        }

        $publications->publicationImages = self::buildPublicationImages($mediaResponse->data);
        $publications->publicationVideos = self::buildPublicationVideos($mediaResponse->data);

        return $publications;
    }

    /**
     * @param MediaItem[] $items
     *
     * @return MediaItem[]
     */
    public static function buildPublicationImages(array $items): array
    {
        $publicationImages = [];

        foreach ($items as $item) {
            if (!$item->caption) {
                continue;
            }

            $validImage = false;

            foreach (self::FILTER_VALID_IMAGE as $filterText) {
                if (\stripos($item->caption, $filterText) !== false) {
                    $validImage = true;

                    break;
                }
            }

            if (
                $validImage
                && ($item->mediaType === MediaTypes::MEDIA_TYPE_IMAGE || $item->mediaType === MediaTypes::MEDIA_TYPE_CAROUSEL_ALBUM)
                && \count($publicationImages) < self::MAX_MEDIA_IMAGES
            ) {
                $publicationImages[] = $item;
            }
        }

        return $publicationImages;
    }

    /**
     * @param MediaItem[] $items
     *
     * @return MediaItem[]
     */
    public static function buildPublicationVideos(array $items): array
    {
        $publicationVideos = [];

        foreach ($items as $item) {
            if ($item->mediaType === MediaTypes::MEDIA_TYPE_VIDEO && \count($publicationVideos) < self::MAX_MEDIA_VIDEOS) {
                $publicationVideos[] = $item;
            }
        }

        return $publicationVideos;
    }
}