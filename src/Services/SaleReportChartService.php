<?php

declare(strict_types=1);

namespace App\Services;

use App\Model\Report\MonthlySales;
use App\Model\Report\WeeklySales;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class SaleReportChartService
{
    private ChartBuilderInterface $chartBuilder;

    public function __construct(ChartBuilderInterface $chartBuilder)
    {
        $this->chartBuilder = $chartBuilder;
    }

    /**
     * @param MonthlySales[] $monthlySalesCollection
     * @param MonthlySales[] $monthlySalesLastYearCollection
     *
     * @return array{monthlySalesTotalChart: Chart, monthlySalesAverageChart: Chart}
     */
    public function getMonthlySalesCharts(array $monthlySalesCollection, array $monthlySalesLastYearCollection): array
    {
        $currentYear = \date('Y');
        $lastYear = \date('Y', strtotime('-1 year'));

        if (!empty($monthlySalesCollection)) {
            $currentYear = \current($monthlySalesCollection)->getYear();
        }

        if (!empty($monthlySalesLastYearCollection)) {
            $lastYear = \current($monthlySalesLastYearCollection)->getYear();
        }

        $MonthFormatter = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
        $MonthFormatter->setPattern("MMMM");
        $dateOfCurrentMonth = new \DateTime();
        $currentMonth = \ucfirst($MonthFormatter->format($dateOfCurrentMonth));

        $monthlySalesLabels = [];
        $monthlySalesLastYearData = [];
        $monthlySalesLastYearWeekAverageData = [];
        $monthlySalesLastYearDailyAverageData = [];

        foreach ($monthlySalesLastYearCollection as $monthlySales) {
            $dateOfMonth = (new \DateTime())->setDate($monthlySales->getYear(), $monthlySales->getMonth(), 1);
            $monthLabel = \ucfirst($MonthFormatter->format($dateOfMonth));
            $monthlySalesLabels[] = $monthLabel !== $currentMonth ? $monthLabel : $monthLabel.' (en curso)';
            $monthlySalesLastYearData[] = $monthlySales->getTotal();
            $monthlySalesLastYearWeekAverageData[] = $monthlySales->getWeeklyAverage();
            $monthlySalesLastYearDailyAverageData[] = $monthlySales->getDailyAverage();
        }

        $monthlySalesData = [];
        $monthlySalesWeekAverageData = [];
        $monthlySalesDailyAverageData = [];

        foreach ($monthlySalesCollection as $monthlySales) {
            $monthlySalesData[] = $monthlySales->getTotal();
            $monthlySalesWeekAverageData[] = $monthlySales->getWeeklyAverage();
            $monthlySalesDailyAverageData[] = $monthlySales->getDailyAverage();
        }

        $monthlySalesTotalChart = ($this->chartBuilder->createChart(Chart::TYPE_BAR))
            ->setData(
                [
                    'labels' => $monthlySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Total mensual ' . $currentYear,
                            'data' => $monthlySalesData,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.4)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'borderWidth' => 1,
                        ],
                        [
                            'label' => 'Total mensual ' . $lastYear,
                            'data' => $monthlySalesLastYearData,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'borderWidth' => 1,
                        ],
                    ],
                ],
            )
            ->setOptions(
                [
                    'scales' => [
                        'y' => [
                            'suggestedMin' => 0,
                            'suggestedMax' => 5000,
                        ],
                    ],
                ]
            )
        ;

        $monthlySalesWeeklyAverageChart = ($this->chartBuilder->createChart(Chart::TYPE_LINE))
            ->setData(
                [
                    'labels' => $monthlySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Media semanal ' . $currentYear,
                            'data' => $monthlySalesWeekAverageData,
                            'backgroundColor' => 'rgba(153, 102, 255, 0.4)',
                            'borderColor' => 'rgb(153, 102, 255)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                        [
                            'label' => 'Media semanal ' . $lastYear,
                            'data' => $monthlySalesLastYearWeekAverageData,
                            'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                            'borderColor' => 'rgb(153, 102, 255)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                    ],
                ]
            )
            ->setOptions(
                [
                    'scales' => [
                        'y' => [
                            'suggestedMin' => 0,
                            'suggestedMax' => 1200,
                        ],
                    ],
                ]
            )
        ;

        $monthlySalesDailyAverageChart = ($this->chartBuilder->createChart(Chart::TYPE_LINE))
            ->setData(
                [
                    'labels' => $monthlySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Media diaria ' . $currentYear,
                            'data' => $monthlySalesDailyAverageData,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
                            'borderColor' => 'rgb(75, 192, 192)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                        [
                            'label' => 'Media diaria ' . $lastYear,
                            'data' => $monthlySalesLastYearDailyAverageData,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.4)',
                            'borderColor' => 'rgb(75, 192, 192)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                    ],
                ]
            )
            ->setOptions(
                [
                    'scales' => [
                        'y' => [
                            'suggestedMin' => 0,
                            'suggestedMax' => 400,
                        ],
                    ],
                ]
            )
        ;

        return [
            'monthlySalesTotalChart' => $monthlySalesTotalChart,
            'monthlySalesWeeklyAverageChart' => $monthlySalesWeeklyAverageChart,
            'monthlySalesDailyAverageChart' => $monthlySalesDailyAverageChart,
        ];
    }

    /**
     * @param WeeklySales[] $weeklySalesCollection
     * @param WeeklySales[] $weeklySalesLastYearCollection
     */
    public function getWeeklySalesTotalChart(array $weeklySalesCollection, array $weeklySalesLastYearCollection): Chart
    {
        $currentYear = \date('Y');
        $lastYear = \date('Y', strtotime('-1 year'));

        if (!empty($weeklySalesCollection)) {
            $currentYear = \current($weeklySalesCollection)->getYear();
        }

        if (!empty($weeklySalesLastYearCollection)) {
            $lastYear = \current($weeklySalesLastYearCollection)->getYear();
        }

        $weeklySalesLabels = [];

        $currentWeek = (int)date("W");

        foreach ($weeklySalesLastYearCollection as $weeklySales) {
            $weekLabel = $weeklySales->getWeekFormatted();
            $weeklySalesLabels[] = $weeklySales->getWeek() !== $currentWeek ? $weekLabel : 'Semana actual';
            $weeklySalesLastYearData[] = $weeklySales->getTotal();
        }

        $weeklySalesData = [];

        foreach ($weeklySalesCollection as $weeklySales) {
            $weeklySalesData[] = $weeklySales->getTotal();
        }

        return ($this->chartBuilder->createChart(Chart::TYPE_BAR))
            ->setData(
                [
                    'labels' => $weeklySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Total semanal ' . $currentYear,
                            'data' => $weeklySalesData,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.4)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'borderWidth' => 1,
                        ],
                        [
                            'label' => 'Total semanal ' . $lastYear,
                            'data' => $weeklySalesLastYearData,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'borderWidth' => 1,
                        ],
                    ],
                ]
            )
            ->setOptions(
                [
                    'scales' => [
                        'y' => [
                            'suggestedMin' => 0,
                            'suggestedMax' => 1600,
                        ],
                    ],
                ]
            )
        ;
    }
}
