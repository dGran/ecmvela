<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Service;

use App\Client\Instagram\Base\Service\BaseService;
use App\Client\Instagram\Media\Exception\InvalidCredentialsException;
use App\Client\Instagram\Media\Model\MediaRequest;
use App\Client\Instagram\Media\Model\MediaResponse;
use App\Helper\Serializer;
use GuzzleHttp\Client;

class MediaService extends BaseService
{
    private const ENDPOINT_MEDIA = "/me/media";

    /**
     * @throws \Exception
     * @throws \Throwable
     */
    public function getMedia(MediaRequest $mediaRequest): MediaResponse
    {
        $client = new Client();

        try {
            $response = $client->request(
                'GET',
                self::BASE_URI.self::ENDPOINT_MEDIA.'?fields='.$mediaRequest->mediaFields.'&access_token='.$this->accessToken.'&limit='.$mediaRequest->limit
            );
            $responseBodyContents = $response->getBody()->getContents();

            return Serializer::deserialize($responseBodyContents, MediaResponse::class, Serializer::FORMAT_JSON);
        } catch (\Throwable $exception) {
            $errorMessage = $exception->getMessage();

            if (\str_contains($errorMessage, InvalidCredentialsException::MESSAGE_NEEDLE)) {
                $this->logger->critical(\DATE_W3C . ' - ' . __METHOD__ . ' - Error validating access token, exception: ' . $errorMessage);
//                $this->systemService->refreshToken();
            } else {
                $this->logger->critical(\DATE_W3C . ' - ' . __METHOD__ . ' - Failed to get publications, exception: ' . $errorMessage);
            }

            return new MediaResponse();
        }
    }
}
