<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Service;

use App\Client\Instagram\Base\Service\BaseService;
use App\Client\Instagram\Media\Model\MediaRequest;
use App\Client\Instagram\Media\Model\MediaResponse;
use App\Utils\Serializer;
use GuzzleHttp\Exception\ClientException;

class MediaService extends BaseService
{
    private const ENDPOINT_MEDIA = "/me/media";

    public function getMedia(MediaRequest $mediaRequest): MediaResponse
    {
        try {
            $response = $this->get(self::ENDPOINT_MEDIA, '', [
                'fields' => $mediaRequest->mediaFields,
                'limit' => $mediaRequest->limit,
            ]);
        } catch (ClientException $exception) {
            $this->logger->error(
                __METHOD__.' ClientException',
                [
                    'exception_message' => $exception->getMessage(),
                    'exception_code' => $exception->getCode(),
                    'exception_class' => \get_class($exception),
                ]
            );

            throw $exception;
        }

        return Serializer::deserialize($response->getRawResponse(), MediaResponse::class, Serializer::FORMAT_JSON);
    }
}
