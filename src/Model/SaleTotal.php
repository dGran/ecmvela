<?php

declare(strict_types=1);

namespace App\Model;

class SaleTotal
{
    /** @var SaleTotalDay[]|null  */
    protected ?array $days = null;
    protected ?float $total = null;

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(?array $days): SaleTotal
    {
        $this->days = $days;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): SaleTotal
    {
        $this->total = $total;

        return $this;
    }
}