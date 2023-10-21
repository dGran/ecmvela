<?php

declare(strict_types=1);

namespace App\Model\Report;

use App\Entity\Sale;

class AnnualSales
{
    private int $year;

    private int $businessDays;

    private int $numberOfSales;

    private float $total;

    private float $monthlyAverage;

    /**
     * @var Sale[] $sales
     */
    private array $sales;

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): AnnualSales
    {
        $this->year = $year;

        return $this;
    }

    public function getBusinessDays(): int
    {
        return $this->businessDays;
    }

    public function setBusinessDays(int $businessDays): AnnualSales
    {
        $this->businessDays = $businessDays;

        return $this;
    }

    public function getNumberOfSales(): int
    {
        return $this->numberOfSales;
    }

    public function setNumberOfSales(int $numberOfSales): AnnualSales
    {
        $this->numberOfSales = $numberOfSales;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): AnnualSales
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Sale[]
     */
    public function getSales(): array
    {
        return $this->sales;
    }

    /**
     * @param Sale[] $sales
     */
    public function setSales(array $sales): AnnualSales
    {
        $this->sales = $sales;

        return $this;
    }

    public function getMonthlyAverage(): float
    {
        return $this->monthlyAverage;
    }

    public function setMonthlyAverage(float $monthlyAverage): AnnualSales
    {
        $this->monthlyAverage = $monthlyAverage;

        return $this;
    }
}
