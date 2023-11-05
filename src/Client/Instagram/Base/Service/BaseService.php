<?php

declare(strict_types=1);

namespace App\Client\Instagram\Base\Service;

use Psr\Log\LoggerInterface;

class BaseService
{
    public const BASE_URI = "https://graph.instagram.com";

    public string $accessToken;

    protected LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        $this->accessToken = $_ENV['INSTAGRAM_ACCESS_TOKEN'];
    }
}
