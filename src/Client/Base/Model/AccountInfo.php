<?php

declare(strict_types=1);

namespace App\Client\Base\Model;

class AccountInfo
{
    public bool $valid = false;

    public ?Token $token = null;
}