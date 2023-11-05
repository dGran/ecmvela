<?php

declare(strict_types=1);

namespace App\Model\View;

use App\Client\Instagram\Media\Model\MediaItem;

class HomeView
{
    /**
     * @var MediaItem[]
     */
    public array $instagramPublicationImages;

    /**
     * @var MediaItem[]
     */
    public array $instagramPublicationVideos;

    /**
     * @var array{userName: string, userImg: string, post: string, review: int}
     */
    public array $googleReviews;
}
