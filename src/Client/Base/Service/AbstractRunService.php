<?php

declare(strict_types=1);

namespace App\Client\Base\Service;

use App\Client\Base\Enums\MethodType;
use App\Client\Base\Enums\StatusTypes;
use App\Client\Base\Factory\RunFactory;
use App\Client\Base\Model\RunResponse;
use App\Utils\Serializer;

/**
 * Class AbstractRunService
 *
 * @author Gonzalo Lacalle <gonzalo.a4b@gmail.com>
 */
abstract class AbstractRunService implements RunServiceInterface
{
    public const USER_AGENT_DEFAULT = 'Estilismo canino Marta Vela';

    protected function run(
        string $method,
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = null
    ): RunResponse {
        return RunFactory::create('Run function not implemented', StatusTypes::HTTP_NOT_IMPLEMENTED, []);
    }

    public function get(
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = null
    ): RunResponse {
        return $this->run(MethodType::TYPE_GET, $endpoint, $bodyContents, $query, $format, $contentType);
    }

    public function post(
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = null
    ): RunResponse {
        return $this->run(MethodType::TYPE_POST, $endpoint, $bodyContents, $query, $format, $contentType);
    }

    public function put(
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = null
    ): RunResponse {
        return $this->run(MethodType::TYPE_PUT, $endpoint, $bodyContents, $query, $format, $contentType);
    }

    public function patch(
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = null
    ): RunResponse {
        return $this->run(MethodType::TYPE_PATCH, $endpoint, $bodyContents, $query, $format, $contentType);
    }

    public function delete(
        string $endpoint,
        string $bodyContents = '',
        array $query = [],
        string $format = Serializer::FORMAT_JSON,
        ?string $contentType = null
    ): RunResponse {
        return $this->run(MethodType::TYPE_DELETE, $endpoint, $bodyContents, $query, $format, $contentType);
    }
}
