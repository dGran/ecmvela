<?php

declare(strict_types=1);

namespace App\Client\Base\Factory;

use App\Client\Base\Model\RunResponse;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class RunFactory
{
    public static function createFromResponse(ResponseInterface $response): RunResponse
    {
        $responseContents = $response->getBody()->getContents();
        $response->getBody()->rewind();

        return self::create($responseContents, $response->getStatusCode(), $response->getHeaders());
    }

    public static function createFromException(\Throwable $exception): RunResponse
    {
        if ($exception instanceof RequestException && $exception->hasResponse()) {
            return self::createFromResponse($exception->getResponse());
        }

        return self::create($exception->getMessage(), $exception->getCode(), []);
    }

    public static function create(string $response, int $responseCode, array $headers): RunResponse
    {
        $runResponse = new RunResponse();
        $runResponse->setRawResponse($response);
        $runResponse->setStatusCode($responseCode);

        $headerResponse = [];

        foreach ($headers as $header => $headerValues) {
            $headerResponse[$header] = end($headerValues);
        }

        $runResponse->setHeaders($headerResponse);

        return $runResponse;
    }
}
