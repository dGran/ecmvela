<?php

declare(strict_types=1);

namespace App\Client\Instagram;

use App\Client\Base\Model\RequestCollection;
use App\Client\Base\Model\ResponseCollection;
use GuzzleHttp\Client;

class MediaRequest
{
    public const USER_AGENT_DEFAULT = 'Estilismo canino Marta Vela';
    public const CONTENT_TYPE_JSON = 'application/json';
    public const MEDIA_BASE_URI = "https://graph.instagram.com";
    public const MEDIA_ENDPOINT = "/me/media";

    /** @var array<string, string> $configuration */
    protected array $configuration;
    protected Client $service;
    protected RequestCollection $request;
    protected ResponseCollection $response;

    public function __construct($configuration)
    {
        $this->configuration = $configuration;
        $this->service = new Client(
            [
                'base_uri' => self::MEDIA_BASE_URI,
                'timeout' => 10,
                'connect_timeout' => 3,
                'headers' => [
                    'User-Agent' => self::USER_AGENT_DEFAULT,
                    'Content-Type' => self::CONTENT_TYPE_JSON,
                ],
            ],
        );

        $this->response = new ResponseCollection();
        $this->request = new RequestCollection();
    }

    public function getService(): Client
    {
        return $this->service;
    }

    public function getRequest(): RequestCollection
    {
        return $this->request;
    }

    public function getResponse(): ResponseCollection
    {
        return $this->response;
    }
}