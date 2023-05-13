<?php

declare(strict_types=1);

namespace App\Services;

use App\Model\Report\MonthlySales;
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

        foreach ($monthlySalesCollection as $monthlySales) {
            $monthlySalesLabels[] = date("F", mktime(0, 0, 0, $monthlySales->getMonth(), 1, $monthlySales->getYear()));
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
                            'label' => 'Ventas mensuales',
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

        $monthlySalesAverageChart = ($this->chartBuilder->createChart(Chart::TYPE_LINE))
            ->setData(
                [
                    'labels' => $monthlySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Media de ventas semanales',
                            'data' => $monthlySalesWeekAverageData,
                            'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                            'borderColor' => 'rgb(153, 102, 255)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                        [
                            'label' => 'Media de ventas diarias',
                            'data' => $monthlySalesDailyAverageData,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
                            'borderColor' => 'rgb(75, 192, 192)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5
                        ],
                    ],
                ]
            )
            ->setOptions(
                [
                    'scales' => [
                        'y' => [
                            'suggestedMin' => 0,
                            'suggestedMax' => 800,
                        ],
                    ],
                ]
            )
        ;

        return [
            'monthlySalesTotalChart' => $monthlySalesTotalChart,
            'monthlySalesAverageChart' => $monthlySalesAverageChart,
        ];
    }
}