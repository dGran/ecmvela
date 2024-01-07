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
        $monthlySalesData = [];
        $monthlySalesLabels = [];

        $Monthformatter = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
        $Monthformatter->setPattern("MMMM");
        $dateOfCurrentMonth = new \DateTime();
        $currentMonth = \ucfirst($Monthformatter->format($dateOfCurrentMonth));

        foreach ($monthlySalesLastYearCollection as $monthlySales) {
            $dateOfMonth = (new \DateTime())->setDate($monthlySales->getYear(), $monthlySales->getMonth(), 1);
            $monthLabel = \ucfirst($Monthformatter->format($dateOfMonth));
            $monthlySalesLabels[] = $monthLabel !== $currentMonth ? $monthLabel : $monthLabel.' (en curso)';
            $monthlySalesLastYearData[] = $monthlySales->getTotal();
            $monthlySalesLastYearWeekAverageData[] = $monthlySales->getWeeklyAverage();
            $monthlySalesLastYearDailyAverageData[] = $monthlySales->getDailyAverage();
        }

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
                            'label' => 'Total mensual '.\current($monthlySalesCollection)->getYear(),
                            'data' => $monthlySalesData,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.4)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'borderWidth' => 1,
                        ],
                        [
                            'label' => 'Total mensual '.\current($monthlySalesLastYearCollection)->getYear(),
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
                            'label' => 'Media semanal '.\current($monthlySalesCollection)->getYear(),
                            'data' => $monthlySalesWeekAverageData,
                            'backgroundColor' => 'rgba(153, 102, 255, 0.4)',
                            'borderColor' => 'rgb(153, 102, 255)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                        [
                            'label' => 'Media semanal '.\current($monthlySalesLastYearCollection)->getYear(),
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
                            'label' => 'Media diaria '.\current($monthlySalesCollection)->getYear(),
                            'data' => $monthlySalesDailyAverageData,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.8)',
                            'borderColor' => 'rgb(75, 192, 192)',
                            'borderWidth' => 1,
                            'fill' => true,
                            'tension' => 0.5,
                        ],
                        [
                            'label' => 'Media diaria '.\current($monthlySalesLastYearCollection)->getYear(),
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
        $weeklySalesData = [];
        $weeklySalesLabels = [];

        $currentWeek = (int)date("W");

        foreach ($weeklySalesLastYearCollection as $weeklySales) {
            $weekLabel = $weeklySales->getWeekFormatted();
            $weeklySalesLabels[] = $weeklySales->getWeek() !== $currentWeek ? $weekLabel : 'Semana actual';
            $weeklySalesLastYearData[] = $weeklySales->getTotal();
        }

        foreach ($weeklySalesCollection as $weeklySales) {
            $weeklySalesData[] = $weeklySales->getTotal();
        }

        return ($this->chartBuilder->createChart(Chart::TYPE_BAR))
            ->setData(
                [
                    'labels' => $weeklySalesLabels,
                    'datasets' => [
                        [
                            'label' => 'Total semanal '.\current($weeklySalesCollection)->getYear(),
                            'data' => $weeklySalesData,
                            'backgroundColor' => 'rgba(54, 162, 235, 0.4)',
                            'borderColor' => 'rgb(54, 162, 235)',
                            'borderWidth' => 1,
                        ],
                        [
                            'label' => 'Total semanal '.\current($weeklySalesLastYearCollection)->getYear(),
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
            );
    }
}
