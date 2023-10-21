<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('adminNavItem')]
class AdminNavItemComponent
{
    public string $path;

    public string $message;

    public ?string $tag = null;

    public ?string $tagBgColor = null;

    public bool $disable = false;

    public ?string $routeFilter = null;

    public function __construct()
    {
        $this->tagBgColor = 'bg-slate-100';
    }
}
