<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Model;

class Publications
{
    /** @var MediaItem[] */
    public array $publicationImages = [];

    /** @var MediaItem[] */
    public array $publicationVideos = [];
}