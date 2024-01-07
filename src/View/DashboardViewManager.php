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

        $dateFromLastYear = (clone $dateFrom)->modify('-1 year');
        $dateToLastYear = (clone $dateTo)->modify('-1 year');

        $dailySales = $this->saleReportService->getDailySales($dateFromLastYear, $dateTo);
        $weeklySales = $this->saleReportService->getWeeklySales($dateFromLastYear, $dateTo);
        $weeklySalesForChart = $this->saleReportService->getWeeklySales($dateFrom, $dateTo);
        $weeklySalesLastYear = $this->saleReportService->getWeeklySales($dateFromLastYear, $dateToLastYear);
        $monthlySales = $this->saleReportService->getMonthlySales($dateFrom, $dateTo);
        $monthlySalesLastYear = $this->saleReportService->getMonthlySales($dateFromLastYear, $dateToLastYear);

        $view->setDailySales($dailySales);
        $view->setWeeklySales($weeklySales);
        $view->setMonthlySales($monthlySales);

        $monthlySalesCharts = $this->saleReportChartService->getMonthlySalesCharts(\array_reverse($monthlySales), \array_reverse($monthlySalesLastYear));
        $weeklySalesTotalChart = $this->saleReportChartService->getWeeklySalesTotalChart(\array_reverse($weeklySalesForChart), \array_reverse($weeklySalesLastYear));

        $view->setMonthlySalesTotalChart($monthlySalesCharts['monthlySalesTotalChart']);
        $view->setWeeklySalesTotalChart($weeklySalesTotalChart);
        $view->setMonthlySalesWeeklyAverageChart($monthlySalesCharts['monthlySalesWeeklyAverageChart']);
        $view->setMonthlySalesDailyAverageChart($monthlySalesCharts['monthlySalesDailyAverageChart']);

        return $view;
    }
}
