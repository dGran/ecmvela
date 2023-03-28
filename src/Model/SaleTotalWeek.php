<?php

declare(strict_types=1);

namespace App\Model;

class SaleTotalWeek
{
    protected ?int $week = null;
    protected ?\DateTime $startDate = null;
    protected ?\DateTime $endDate = null;
    protected ?float $total = null;

    public function getWeek(): ?int
    {
        return $this->week;
    }

    public function setWeek(?int $week): SaleTotalWeek
    {
        $this->week = $week;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTime $startDate): SaleTotalWeek
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): SaleTotalWeek
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): SaleTotalWeek
    {
        $this->total = $total;

        return $this;
    }
}