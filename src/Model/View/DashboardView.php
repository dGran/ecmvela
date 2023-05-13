<?php

declare(strict_types=1);

namespace App\Model\View;

use App\Model\Report\DailySales;
use App\Model\Report\MonthlySales;
use App\Model\Report\WeeklySales;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardView
{
    /**
     * @var DailySales[]
     */
    private array $dailySales;

    /**
     * @var WeeklySales[]
     */
    private array $weeklySales;

    /**
     * @var MonthlySales[]
     */
    private array $monthlySales;

    private ?Chart $monthlySalesTotalChart = null;

    private ?Chart $monthlySalesAverageChart = null;

    /**
     * @return DailySales[]
     */
    public function getDailySales(): array
    {
        return $this->dailySales;
    }

    /**
     * @param DailySales[] $dailySales
     */
    public function setDailySales(array $dailySales): DashboardView
    {
        $this->dailySales = $dailySales;

        return $this;
    }

    /**
     * @return WeeklySales[]
     */
    public function getWeeklySales(): array
    {
        return $this->weeklySales;
    }

    /**
     * @param WeeklySales[] $weeklySales
     */
    public function setWeeklySales(array $weeklySales): DashboardView
    {
        $this->weeklySales = $weeklySales;

        return $this;
    }

    /**
     * @return MonthlySales[]
     */
    public function getMonthlySales(): array
    {
        return $this->monthlySales;
    }

    /**
     * @param MonthlySales[] $monthlySales
     */
    public function setMonthlySales(array $monthlySales): DashboardView
    {
        $this->monthlySales = $monthlySales;

        return $this;
    }

    public function getMonthlySalesTotalChart(): ?Chart
    {
        return $this->monthlySalesTotalChart;
    }

    public function setMonthlySalesTotalChart(?Chart $monthlySalesTotalChart): DashboardView
    {
        $this->monthlySalesTotalChart = $monthlySalesTotalChart;

        return $this;
    }

    public function getMonthlySalesAverageChart(): ?Chart
    {
        return $this->monthlySalesAverageChart;
    }

    public function setMonthlySalesAverageChart(?Chart $monthlySalesAverageChart): DashboardView
    {
        $this->monthlySalesAverageChart = $monthlySalesAverageChart;

        return $this;
    }
}