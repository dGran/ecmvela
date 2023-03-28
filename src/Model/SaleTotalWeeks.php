<?php

declare(strict_types=1);

namespace App\Model;

class SaleTotalWeeks
{
    /** @var SaleTotalWeek[]|null  */
    protected ?array $weeks = null;
    protected ?float $total = null;

    public function getWeeks(): ?array
    {
        return $this->weeks;
    }

    public function setWeeks(?array $weeks): SaleTotalWeeks
    {
        $this->weeks = $weeks;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): SaleTotalWeeks
    {
        $this->total = $total;

        return $this;
    }
}