<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('headerLinkMobile')]
#
class HeaderLinkMobileComponent
{
    public string $path;
    public string $message;
}