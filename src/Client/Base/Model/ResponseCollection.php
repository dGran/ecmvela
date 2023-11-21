<?php

declare(strict_types=1);

namespace App\Client\Base\Model;

/**
 * Class ResponseCollection
 */
class ResponseCollection
{
    public array $responses;

    public function __construct()
    {
        $this->responses = [];
    }

    public function getResponses(): array
    {
        return $this->responses;
    }

    public function addResponse($response): ResponseCollection
    {
        $this->responses[] = $response;

        return $this;
    }
}
