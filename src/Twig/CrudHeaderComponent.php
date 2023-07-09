<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('crudHeaderComponent')]
final class CrudHeaderComponent
{
    public ?string $section = null;
    public ?string $title = null;
    public ?string $description = null;
}
