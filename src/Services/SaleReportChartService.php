<?php

declare(strict_types=1);

namespace App\Services;

use App\Model\Report\MonthlySales;
use App\Model\Report\WeeklySales;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class SaleReportChartService
{
    public function __construct(private readonly ChartBuilderInterface $chartBuilder)
    {
    }

    /**
     * @param MonthlySales[] $monthlySalesCollection
     *
     * @return array{monthlySalesTotalChart: Chart, monthlySalesAverageChart: Chart}
     */
    public function getMonthlySalesCharts(array $monthlySalesCollection): array
    {
        $monthlySalesData = [];
        $monthlySalesLabels = [];

        $Monthformatter = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
        $Monthformatter->setPattern("MMMM");
        $dateOfCurrentMonth = new \DateTime();
        $currentMonth = \ucfirst($Monthformatter->format($dateOfCurrentMonth));

        foreach ($monthlySalesCollection as $monthlySales) {
            $dateOfMonth = (new \DateTime())->setDate($monthlySales->getYear(), $monthlySales->getMonth(), 1);
            $monthLabel = \ucfirst($Monthformatter->format($dateOfMonth));
            $monthlySalesLabels[] = $monthLabel !== $currentMonth ? $monthLabel : $monthLabel.' (en curso)';
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
                            'label' => 'Total ventas mensual',
                            'data' => $monthlySalesData,
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
                            'suggestedMax' => 4000,
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
                            'label' => 'MediaItem de ventas semanal',
                            'data' => $monthlySalesWeekAverageData,
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
                            'suggestedMax' => 1000,
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
                            'label' => 'MediaItem de ventas diaria',
                            'data' => $monthlySalesDailyAverageData,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
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
                            'suggestedMax' => 200,
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
     */
    public function getWeeklySalesTotalChart(array $weeklySalesCollection): Chart
    {
        $weeklySalesData = [];
        $weeklySalesLabels = [];

        $currentWeek = (int)date("W");

        foreach ($weeklySalesCollection as $weeklySales) {
            $weekLabel = $weeklySales->getWeekFormatted();
            $weeklySalesLabels[] = $weeklySales->getWeek() !== $currentWeek ? $weekLabel : 'Semana actual';
            $weeklySalesData[] = $weeklySales->getTotal();
        }

        return ($this->chartBuilder->createChart(Chart::TYPE_BAR))
            ->setData(
                [
                    'labels' => $weeklySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Total ventas semanal',
                            'data' => $weeklySalesData,
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
                            'suggestedMax' => 1000,
                        ],
                    ],
                ]
            );
    }
}
