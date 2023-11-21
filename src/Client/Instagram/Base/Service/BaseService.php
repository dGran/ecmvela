<?php

declare(strict_types=1);

namespace App\Client\Instagram\Base\Service;

use App\Client\Instagram\Base\Exceptions\InvalidCredentialsException;
use App\Client\Base\Factory\RunFactory;
use App\Client\Base\Model\RequestCollection;
use App\Client\Base\Model\ResponseCollection;
use App\Client\Base\Model\RunResponse;
use App\Client\Base\Service\AbstractRunService;
use App\Client\Base\Service\BaseServiceInterface;
use App\Utils\Logger;
use App\Utils\Serializer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BaseService extends AbstractRunService implements BaseServiceInterface
{
    public Logger $logger;

    private const BASE_URI = "https://graph.instagram.com";

    private const CONTENT_TYPE = 'application/json';

    public const ACCESS_TOKEN = 'access_token';

    public const EXPIRES_IN = 'expires_in';

    public const GRANT_TYPE = 'grant_type';

    protected array $configuration;

    protected string $serviceUrl;

    protected RequestCollection $request;

    protected ResponseCollection $response;

    protected ?string $accessToken;

    private Client $service;

    private ?string $expiresIn;

    private bool $logInfo = true;

    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        $this->accessToken = $this->configuration[self::ACCESS_TOKEN];
        $this->expiresIn = $this->configuration[self::EXPIRES_IN];
        $this->serviceUrl = self::BASE_URI;
        $this->service = new Client(
            [
                'timeout' => 10,
                'connect_timeout' => 3,
                'base_uri' => $this->serviceUrl,
                'headers' => [
                    'User-Agent' => self::USER_AGENT_DEFAULT,
                    'Content-Type' => self::CONTENT_TYPE,
                ],
            ]
        );
        $this->request = new RequestCollection();
        $this->response = new ResponseCollection();
        $this->logger = Logger::getInstance();
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

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getExpiresIn(): ?string
    {
        return $this->expiresIn;
    }

    /**
     * @throws \Throwable
     * @throws GuzzleException
     * @throws InvalidCredentialsException
     */
    protected function run(
        string $method,
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = self::CONTENT_TYPE
    ): RunResponse {
        $options = [
            'headers' => [
                'Authorization' => 'Bearer '.$this->accessToken,
                'Cache-Control' => 'no-cache',
            ],
            'allow_redirects' => false,
        ];

        if (!empty($contentType)) {
            $options['headers']['Content-Type'] = $contentType;
            $options['headers']['Accept'] = $contentType;
        }

        if (!empty($bodyContents)) {
            $options['body'] = $bodyContents;
        }

        if (!empty($query)) {
            $options['query'] = $query;
        }

        $requestData = ['method' => $method, 'uri' => $endpoint, 'options' => $options, ];
        $this->request->addRequest($requestData);

        if ($this->logInfo) {
            $this->logger->info(__METHOD__.' Processing new request: ', $requestData);
        }

        try {
            $response = $this->getService()->request($method, $endpoint, $options);
            $runResponse = RunFactory::createFromResponse($response);

            $responseData = [
                'method' => $method,
                'endpoint' => $endpoint,
                'headers' => $options,
                'run_response' => $runResponse,
            ];
            $this->response->addResponse($responseData);

            if ($this->logInfo) {
                $this->logger->info(__METHOD__.' Processing response request: ', $responseData);
            }

            return $runResponse;
        } catch (\Throwable $exception) {
            $runResponse = RunFactory::createFromException($exception);
            $responseData = [
                'method' => $method,
                'endpoint' => $endpoint,
                'run_response' => $runResponse,
                'status_code' => $runResponse->getStatusCode(),
                'headers' => $runResponse->getHeaders(),
            ];
            $this->response->addResponse($responseData);

            InvalidCredentialsException::handle($runResponse->getRawResponse());

            $this->logger->critical(
                __METHOD__.' Method: '.$method.' exceptionMessage: '.$exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'exception_class' => \get_class($exception),
                    'request_data' => $requestData,
                    'response_data' => $responseData,
                ]
            );

            throw $exception;
        }
    }
}
