<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('titleUnderline')]
#
class TitleUnderlineComponent
{
    public string $color = 'fuchsia-900/70';
}