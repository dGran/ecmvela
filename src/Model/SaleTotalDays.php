<?php

declare(strict_types=1);

namespace App\Model;

class SaleTotalDays
{
    /** @var SaleTotalDay[]|null  */
    protected ?array $days = null;
    protected ?float $total = null;

    public function getDays(): ?array
    {
        return $this->days;
    }

    /**
     * @param SaleTotalDay[]|null $days
     */
    public function setDays(?array $days): SaleTotalDays
    {
        $this->days = $days;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): SaleTotalDays
    {
        $this->total = $total;

        return $this;
    }
}