<?php

declare(strict_types=1);

namespace App\Client\Instagram\System\Model;

use JMS\Serializer\Annotation as Serializer;

class UpdateTokenResponse
{
    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("access_token")
     */
    public ?string $accessToken = nulL;

    /**
     * @Serializer\Type("string")
     * @Serializer\SerializedName("token_type")
     */
    public ?string $tokenType = nulL;

    /**
     * @Serializer\Type("int")
     * @Serializer\SerializedName("expires_in")
     */
    public ?int $expiresIn = nulL;
}
