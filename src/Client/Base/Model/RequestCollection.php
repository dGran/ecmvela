<?php

declare(strict_types=1);

namespace App\Client\Base\Model;

/**
 * Class RequestCollection
 */
class RequestCollection
{
    public array $requests;

    public function __construct()
    {
        $this->requests = [];
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function addRequest($request): RequestCollection
    {
        $this->requests[] = $request;

        return $this;
    }
}
