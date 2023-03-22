<?php

declare(strict_types=1);

namespace App\Model;

class SaleTotalDay
{
    protected ?\DateTime $day = null;
    protected ?float $total = null;

    public function getDay(): ?\DateTime
    {
        return $this->day;
    }

    public function setDay(?\DateTime $day): SaleTotalDay
    {
        $this->day = $day;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): SaleTotalDay
    {
        $this->total = $total;

        return $this;
    }
}