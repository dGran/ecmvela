<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('label')]
#
class LabelComponent
{
    public string $textSize = 'sm';
    public ?string $inputId = null;
    public string $label;
}