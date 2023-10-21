<?php

declare(strict_types=1);

namespace App\Services;

use App\Manager\PetManager;

class PetService
{
    private PetManager $saleManager;

    public function __construct(PetManager $petManager)
    {
        $this->petManager = $petManager;
    }
}
