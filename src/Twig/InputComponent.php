<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('input')]
class InputComponent
{
    public string $type = 'text';
    public string $textSize = 'sm';
    public string $placeHolder = '';
    public ?string $id = null;
    public string $name = '';
}