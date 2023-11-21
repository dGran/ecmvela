<?php

declare(strict_types=1);

namespace App\Client\Instagram\System\Factory;

use App\Client\Base\Model\Token;
use App\Client\Instagram\System\Model\UpdateTokenResponse;

class TokenFactory
{
    public static function build(string $accessToken, \DateTime $dateExpirationToken): Token
    {
        $token = new Token();
        $token->token = $accessToken;
        $token->dateExpirationToken = $dateExpirationToken;

        return $token;
    }

    public static function buildFromUpdateTokenResponse(UpdateTokenResponse $updateTokenResponse): Token
    {
        $dateExpirationToken = (new \DateTime())->modify('+'.$updateTokenResponse->expiresIn.' seconds');

        return self::build($updateTokenResponse->accessToken, $dateExpirationToken);
    }
}
