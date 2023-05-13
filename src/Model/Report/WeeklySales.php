<?php

declare(strict_types=1);

namespace App\Model\Report;

use App\Entity\Sale;

class WeeklySales
{
    private int $week;

    private string $weekFormatted;

    private int $year;

    private \DateTime $dateFrom;

    private \DateTime $dateTo;

    private int $businessDays;

    private int $numberOfSales;

    private float $total;

    private float $dailyAverage;

    /**
     * @var Sale[] $sales
     */
    private array $sales;

    public function getWeek(): int
    {
        return $this->week;
    }

    public function setWeek(int $week): WeeklySales
    {
        $this->week = $week;

        return $this;
    }

    public function getWeekFormatted(): string
    {
        return $this->weekFormatted;
    }

    public function setWeekFormatted(string $weekFormatted): WeeklySales
    {
        $this->weekFormatted = $weekFormatted;

        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): WeeklySales
    {
        $this->year = $year;

        return $this;
    }

    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    public function setDateFrom(\DateTime $dateFrom): WeeklySales
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    public function setDateTo(\DateTime $dateTo): WeeklySales
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    public function getBusinessDays(): int
    {
        return $this->businessDays;
    }

    public function setBusinessDays(int $businessDays): WeeklySales
    {
        $this->businessDays = $businessDays;

        return $this;
    }

    public function getNumberOfSales(): int
    {
        return $this->numberOfSales;
    }

    public function setNumberOfSales(int $numberOfSales): WeeklySales
    {
        $this->numberOfSales = $numberOfSales;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): WeeklySales
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
    public function setSales(array $sales): WeeklySales
    {
        $this->sales = $sales;

        return $this;
    }

    public function getDailyAverage(): float
    {
        return $this->dailyAverage;
    }

    public function setDailyAverage(float $dailyAverage): WeeklySales
    {
        $this->dailyAverage = $dailyAverage;

        return $this;
    }
}