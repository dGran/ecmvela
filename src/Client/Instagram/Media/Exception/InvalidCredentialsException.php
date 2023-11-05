<?php

declare(strict_types=1);

namespace App\Client\Instagram\Media\Exception;

class InvalidCredentialsException extends \Exception
{
    public const MESSAGE_NEEDLE = 'Error validating access token';

    public function __construct(string $message = self::MESSAGE_NEEDLE)
    {
        parent::__construct($message);
    }
}