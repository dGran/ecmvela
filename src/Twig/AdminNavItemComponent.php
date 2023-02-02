<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('adminNavItem')]
class AdminNavItemComponent
{
    public string $path;
    public string $message;
    public string $tag = '';
    public string $tagColor = 'rose';
}