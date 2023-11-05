<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Factory;

use App\Client\Instagram\Media\Model\MediaRequest;

class PublicationRequestFactory
{
    private const MEDIA_FIELDS = [
        'id',
        'caption',
        'media_type',
        'media_url',
        'permalink',
        'timestamp',
    ];

    private const MEDIA_FIELDS_SEPARATOR = ',';

    public static function build(int $limit): MediaRequest
    {
        $publicationRequest = new MediaRequest();

        $publicationRequest->mediaFields = \implode(self::MEDIA_FIELDS_SEPARATOR, self::MEDIA_FIELDS);
        $publicationRequest->limit = $limit;

        return $publicationRequest;
    }
}