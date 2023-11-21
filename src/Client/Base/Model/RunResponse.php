<?php

declare(strict_types=1);

namespace App\Client\Base\Model;

class RunResponse
{
    public string $rawResponse;

    public array $headers;

    public int $statusCode;

    public ?string $redirectUri = null;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): RunResponse
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getRawResponse(): string
    {
        return $this->rawResponse;
    }

    public function setRawResponse(string $rawResponse): RunResponse
    {
        $this->rawResponse = $rawResponse;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): RunResponse
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeader(string $headerKey)
    {
        return $this->headers[$headerKey];
    }

    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    public function setRedirectUri(?string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }
}