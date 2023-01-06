<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert')]
class AlertComponent
{
    public string $type = 'success';
    public string $message;
    public string $size = 'sm';

    public function getAlertClass(): string
    {
        return match ($this->type) {
            'success' => 'green',
            'error' => 'red',
            'warning' => 'yellow'
        };
    }
}