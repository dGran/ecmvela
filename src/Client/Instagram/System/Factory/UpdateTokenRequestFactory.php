<?php

declare(strict_types=1);

namespace App\Client\Instagram\System\Factory;

use App\Client\Instagram\Enums\GrantTypes;

class UpdateTokenRequestFactory
{
    /**
     * @param string $refreshToken
     *
     * @return array{grant_type: string, access_token: string}
     */
    public static function build(string $refreshToken): array
    {
        return array(
            'grantType' => GrantTypes::GRANT_TYPE_REFRESH_TOKEN,
            'accessToken' => $refreshToken,
        );
    }
}
