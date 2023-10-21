<?php

declare(strict_types=1);

namespace App\Model\Report;

use App\Entity\Sale;

class MonthlySales
{
    private int $month;

    private int $year;

    private int $businessDays;

    private int $businessWeeks;

    private int $numberOfSales;

    private float $total;

    private float $dailyAverage;

    private float $weeklyAverage;

    /**
     * @var Sale[] $sales
     */
    private array $sales;

    public function getMonth(): int
    {
        return $this->month;
    }

    public function setMonth(int $month): MonthlySales
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): MonthlySales
    {
        $this->year = $year;

        return $this;
    }

    public function getBusinessDays(): int
    {
        return $this->businessDays;
    }

    public function setBusinessDays(int $businessDays): MonthlySales
    {
        $this->businessDays = $businessDays;

        return $this;
    }

    public function getBusinessWeeks(): int
    {
        return $this->businessWeeks;
    }

    public function setBusinessWeeks(int $businessWeeks): MonthlySales
    {
        $this->businessWeeks = $businessWeeks;

        return $this;
    }

    public function getNumberOfSales(): int
    {
        return $this->numberOfSales;
    }

    public function setNumberOfSales(int $numberOfSales): MonthlySales
    {
        $this->numberOfSales = $numberOfSales;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): MonthlySales
    {
        $this->total = $total;

        return $this;
    }

    public function getDailyAverage(): float
    {
        return $this->dailyAverage;
    }

    public function setDailyAverage(float $dailyAverage): MonthlySales
    {
        $this->dailyAverage = $dailyAverage;

        return $this;
    }

    public function getWeeklyAverage(): float
    {
        return $this->weeklyAverage;
    }

    public function setWeeklyAverage(float $weeklyAverage): MonthlySales
    {
        $this->weeklyAverage = $weeklyAverage;

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
    public function setSales(array $sales): MonthlySales
    {
        $this->sales = $sales;

        return $this;
    }
}
