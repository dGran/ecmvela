<?php

declare(strict_types=1);

namespace App\View;

use App\Model\View\DashboardView;
use App\Services\SaleReportChartService;
use App\Services\SaleReportService;

class DashboardViewManager
{
    public function __construct(
        private readonly SaleReportService $saleReportService,
        private readonly SaleReportChartService $saleReportChartService
    ) {
    }

    /**
     * @throws \Exception
     */
    public function build(\DateTime $dateFrom, \DateTime $dateTo): DashboardView
    {
        $view = new DashboardView();

        $dailySales = $this->saleReportService->getDailySales($dateFrom, $dateTo);
        $weeklySales = $this->saleReportService->getWeeklySales($dateFrom, $dateTo);
        $monthlySales = $this->saleReportService->getMonthlySales($dateFrom, $dateTo);

        $view->setDailySales($dailySales);
        $view->setWeeklySales($weeklySales);
        $view->setMonthlySales($monthlySales);

        $monthlySalesCharts = $this->saleReportChartService->getMonthlySalesCharts($monthlySales);
        $weeklySalesTotalChart = $this->saleReportChartService->getWeeklySalesTotalChart($weeklySales);

        $view->setMonthlySalesTotalChart($monthlySalesCharts['monthlySalesTotalChart']);
        $view->setWeeklySalesTotalChart($weeklySalesTotalChart);
        $view->setMonthlySalesWeeklyAverageChart($monthlySalesCharts['monthlySalesWeeklyAverageChart']);
        $view->setMonthlySalesDailyAverageChart($monthlySalesCharts['monthlySalesDailyAverageChart']);

        return $view;
    }
}
