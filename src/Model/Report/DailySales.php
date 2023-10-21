<?php

declare(strict_types=1);

namespace App\Model\Report;

use App\Entity\Sale;

class DailySales
{
    private \DateTime $date;

    private string $dateFormatted;

    private int $numberOfSales;

    private float $total;

    /**
     * @var Sale[] $sales
     */
    private array $sales;

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): DailySales
    {
        $this->date = $date;

        return $this;
    }

    public function getDateFormatted(): string
    {
        return $this->dateFormatted;
    }

    public function setDateFormatted(string $dateFormatted): DailySales
    {
        $this->dateFormatted = $dateFormatted;

        return $this;
    }

    public function getNumberOfSales(): int
    {
        return $this->numberOfSales;
    }

    public function setNumberOfSales(int $numberOfSales): DailySales
    {
        $this->numberOfSales = $numberOfSales;

        return $this;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function setTotal(float $total): DailySales
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
    public function setSales(array $sales): DailySales
    {
        $this->sales = $sales;

        return $this;
    }
}
