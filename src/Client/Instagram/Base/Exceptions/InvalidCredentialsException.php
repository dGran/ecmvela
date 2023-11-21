<?php

declare(strict_types=1);

namespace App\Client\Instagram\Base\Exceptions;

use App\Client\Base\Enums\StatusTypes;
use App\Client\Base\Exceptions\InvalidCredentialsException as InvalidCredentialsExceptionBase;

class InvalidCredentialsException extends InvalidCredentialsExceptionBase
{
    public const MESSAGE = 'Access token invalid';

    private const MESSAGE_NEEDLE = 'Error validating access token';

    public function __construct()
    {
        parent::__construct(self::MESSAGE, StatusTypes::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws InvalidCredentialsException
     */
    public static function handle(string $rawResponse): void
    {
        if (\str_contains($rawResponse, self::MESSAGE_NEEDLE)) {
            throw new self();
        }
    }
}
