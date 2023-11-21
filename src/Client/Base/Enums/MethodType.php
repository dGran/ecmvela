<?php

declare(strict_types=1);

namespace App\Client\Base\Enums;

class MethodType extends EnumType
{
    public const TYPE_POST = 'POST';

    public const TYPE_PATCH = 'PATCH';

    public const TYPE_PUT = 'PUT';

    public const TYPE_GET = 'GET';

    public const TYPE_DELETE = 'DELETE';
}
