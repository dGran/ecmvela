<?php

declare(strict_types=1);

namespace App\Model\View;

use App\Model\SaleTotal;

class DashboardView
{
    protected ?SaleTotal $saleTotal = null;

    public function getSaleTotal(): ?SaleTotal
    {
        return $this->saleTotal;
    }

    public function setSaleTotal(?SaleTotal $saleTotal): DashboardView
    {
        $this->saleTotal = $saleTotal;

        return $this;
    }
}