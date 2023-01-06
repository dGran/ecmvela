<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('headerLink')]
#
class HeaderLinkComponent
{
    public string $path;
    public string $message;
}