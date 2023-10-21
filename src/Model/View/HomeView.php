<?php

declare(strict_types=1);

namespace App\Model\View;

class HomeView
{
    /**
     * @var array{media_url: string, permalink: string, date: int}
     */
    public array $instagramPublicationImages;

    /**
     * @var array{media_url: string, permalink: string, date: int}
     */
    public array $instagramPublicationVideos;

    /**
     * @var array{userName: string, userImg: string, post: string, review: int}
     */
    public array $googleReviews;
}
