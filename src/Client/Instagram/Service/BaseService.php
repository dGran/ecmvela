<?php

declare(strict_types=1);

namespace App\Client\Instagram\Service;

class BaseService
{
    public const BASE_URI = "https://graph.instagram.com";

    public string $accessToken;

    public function __construct()
    {
        $this->accessToken = $_ENV['INSTAGRAM_ACCESS_TOKEN'];
    }
}