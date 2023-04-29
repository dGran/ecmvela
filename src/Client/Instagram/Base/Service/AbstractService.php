<?php

declare(strict_types=1);

namespace App\Client\Instagram\Base\Service;

use App\Helper\Serializer;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use JMS\Serializer\SerializerBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AbstractService
{
    private const REQUEST_FAILED_MESSAGE = 'Failed to process request.';
    private const CLIENT_TIMEOUT_SECONDS = 10;

    protected ClientInterface $client;
    protected \JMS\Serializer\Serializer $serializer;
    protected string $requestFormat;
    protected string $responseFormat;
    protected LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger,
        ParameterBagInterface $parameterBag,
        string $requestFormat = Serializer::FORMAT_JSON,
        string $responseFormat = Serializer::FORMAT_JSON
    ) {
        $baseUri = $parameterBag->get('instagram_app_base_uri');
        $token = $parameterBag->get('instagram_app_token');

        $this->requestFormat = $requestFormat;
        $this->responseFormat = $responseFormat;
        $this->serializer = SerializerBuilder::create()->build();
        $this->logger = $logger;
        $this->client = new Client(
            [
                'connection_timeout' => 10,
                'base_uri' => $baseUri,
                'headers' => [
                    'token' => $token,
                    'ContentType' => 'application/'.$requestFormat,
                    'Accept' => 'application/'.$responseFormat,
                ],
                'timeout' => self::CLIENT_TIMEOUT_SECONDS,
            ]
        );
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): AbstractService
    {
        $this->client = $client;

        return $this;
    }

    public function setLogger(LoggerInterface $logger): AbstractService
    {
        $this->logger = $logger;

        return $this;
    }

    protected function get(string $url, string $type = 'array')
    {
        $response = '';

        try {
            $response = $this->client->get($url)->getBody()->getContents();

            return $this->deserialize($response, $type);
        } catch (\Exception $exception) {
            $this->logger->error(
                'GET: '.static::class." URL: $url TYPE: $type MESSAGE: ".$exception->getMessage(),
                [$response]
            );
        }

        return false;
    }

    /**
     * @throws \Exception
     */
    protected function serialize($data): string{
        try {
            return $this->serializer->serialize($data, $this->requestFormat);
        } catch (\Exception $exception) {
            $this->logger->critical(__METHOD__.' '.$exception->getMessage());

            throw $exception;
        }
    }

    /**
     * @throws \Exception
     */
    protected function deserialize(string $dataContents, string $type)
    {
        try {
            return $this->serializer->deserialize($dataContents, $type, $this->responseFormat);
        } catch (\Exception $exception) {
            $this->logger->critical(
                __METHOD__.' '.$exception->getMessage(),
                [$dataContents, $type, $this->responseFormat]
            );

            throw $exception;
        }
    }
}