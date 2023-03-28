<?php

declare(strict_types=1);

namespace App\Model\View;

use App\Model\SaleTotalDays;
use App\Model\SaleTotalWeeks;

class DashboardView
{
    protected ?SaleTotalDays $saleTotalDays = null;
    protected ?SaleTotalWeeks $saleTotalWeeks = null;

    public function getSaleTotalDays(): ?SaleTotalDays
    {
        return $this->saleTotalDays;
    }

    public function setSaleTotalDays(?SaleTotalDays $saleTotal): DashboardView
    {
        $this->saleTotalDays = $saleTotal;

        return $this;
    }

    public function getSaleTotalWeeks(): ?SaleTotalWeeks
    {
        return $this->saleTotalWeeks;
    }

    public function setSaleTotalWeeks(?SaleTotalWeeks $saleTotalWeeks): DashboardView
    {
        $this->saleTotalWeeks = $saleTotalWeeks;

        return $this;
    }
}