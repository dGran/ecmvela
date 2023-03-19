<?php

declare(strict_types=1);

namespace App\Model;

class SalePaymentInfo
{
    protected ?string $state = null;
    protected ?float $totalPaid = null;

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): SalePaymentInfo
    {
        $this->state = $state;

        return $this;
    }

    public function getTotalPaid(): ?float
    {
        return $this->totalPaid;
    }

    public function setTotalPaid(?float $totalPaid): SalePaymentInfo
    {
        $this->totalPaid = $totalPaid;

        return $this;
    }
}