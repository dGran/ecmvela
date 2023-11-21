<?php

declare(strict_types=1);

namespace App\Client\Base\Service;

use App\Client\Base\Model\RequestCollection;
use App\Client\Base\Model\ResponseCollection;

interface BaseServiceInterface
{
    public function __construct(array $configuration);

    public function getService();

    public function getRequest(): RequestCollection;

    public function getResponse(): ResponseCollection;
}
