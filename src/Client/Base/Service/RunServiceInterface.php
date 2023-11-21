<?php

declare(strict_types=1);

namespace App\Client\Base\Service;

use App\Client\Base\Model\RunResponse;
use App\Utils\Serializer;

interface RunServiceInterface
{
    public function get(string $endpoint, string $bodyContents = '', array $query = [], string $format = Serializer::FORMAT_JSON, ?string $contentType = null): RunResponse;

    public function post(string $endpoint, string $bodyContents = '', array $query = [], string $format = Serializer::FORMAT_JSON, ?string $contentType = null): RunResponse;

    public function put(string $endpoint, string $bodyContents = '', array $query = [], string $format = Serializer::FORMAT_JSON, ?string $contentType = null): RunResponse;

    public function patch(string $endpoint, string $bodyContents = '', array $query = [], string $format = Serializer::FORMAT_JSON, ?string $contentType = null): RunResponse;

    public function delete(string $endpoint, string $bodyContents = '', array $query = [], string $format = Serializer::FORMAT_JSON, ?string $contentType = null): RunResponse;
}
