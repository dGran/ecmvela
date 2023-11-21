<?php

declare(strict_types=1);

namespace App\Client\Base\Model;

class Token
{
    public ?string $token = null;

    public ?string $refreshToken = null;

    public ?\DateTime $dateExpirationToken = null;
}