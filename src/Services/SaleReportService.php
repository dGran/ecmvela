<?php

declare(strict_types=1);

namespace App\Services;

use App\Manager\SaleManager;
use App\Model\Report\DailySales;
use App\Model\Report\MonthlySales;
use App\Model\Report\Sale;
use App\Model\Report\WeeklySales;

class SaleReportService
{
    public function __construct(private readonly SaleManager $saleManager)
    {
    }

    /**
     * @return DailySales[]
     */
    public function getDailySales(\DateTime $reportDateFrom, \DateTime $reportDateTo): array
    {
        $salesGroupedByDay = $this->saleManager->findByRangeDateGroupedByDay($reportDateFrom, $reportDateTo);
        $dailySalesCollection = [];

        foreach ($salesGroupedByDay as $salesByDay) {
            $dateFormat = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::FULL, \IntlDateFormatter::NONE);
            $date = \DateTime::createFromFormat('Y-m-d', $salesByDay['day'])->setTime(0, 0);
            $dateFormatted = $dateFormat->format($date);

            $dailySales = new DailySales();
            $dailySales->setDate($date);
            $dailySales->setDateFormatted(\ucfirst($dateFormatted));
            $dailySales->setTotal($salesByDay['total']);
            $dailySales->setNumberOfSales($salesByDay['numberOfSales']);

            $salesOfDay = $this->saleManager->findByDate($salesByDay['day']);
            $salesOfDayCollection = [];

            foreach ($salesOfDay as $saleOfDay) {
                $sale = new Sale();
                $sale->setId($saleOfDay->getId());
                $sale->setDate($saleOfDay->getDateAdd());
                $sale->setTotal($saleOfDay->getTotal());
                $sale->setPet($saleOfDay->getPet());
                $sale->setCustomer($saleOfDay->getCustomer());
                $salesOfDayCollection[] = $sale;
            }

            $dailySales->setSales($salesOfDayCollection);
            $dailySalesCollection[] = $dailySales;
        }

        return $dailySalesCollection;
    }

    /**
     * @return WeeklySales[]
     */
    public function getWeeklySales(\DateTime $reportDateFrom, \DateTime $reportDateTo): array
    {
        $salesGroupedByWeek = $this->saleManager->findByRangeDateGroupedByWeek($reportDateFrom, $reportDateTo);
        $weeklySalesCollection = [];

        foreach ($salesGroupedByWeek as $salesByWeek) {
            $year = $salesByWeek['year'];
            $week = $salesByWeek['week'];
            $weekDateFrom = new \DateTime();
            ($weekDateFrom)->setISODate($year, $week)->setTime(0, 0);
            $weekDateTo = new \DateTime();
            ($weekDateTo)->setISODate($year, $week, 7)->setTime(23, 59, 59);
            $weekFormatted = $weekDateFrom->format('d-m-y').' / '.$weekDateTo->format('d-m-y');

            $weeklySales = new WeeklySales();
            $weeklySales->setTotal($salesByWeek['total']);
            $weeklySales->setWeek($week);
            $weeklySales->setWeekFormatted($weekFormatted);
            $weeklySales->setYear($year);
            $weeklySales->setDateFrom($weekDateFrom);
            $weeklySales->setDateTo($weekDateTo);

            $salesOfWeek = $this->saleManager->findByDateRange($weekDateFrom, $weekDateTo);
            $salesOfWeekCollection = [];

            $currentDay = null;
            $businessDays = 0;

            foreach ($salesOfWeek as $saleOfWeek) {
                $saleOfWeekDay = (int)($saleOfWeek->getDateAdd())->format('N');

                if ($saleOfWeekDay !== $currentDay) {
                    $currentDay = $saleOfWeekDay;
                    $businessDays++;
                }

                $sale = new Sale();
                $sale->setId($saleOfWeek->getId());
                $sale->setDate($saleOfWeek->getDateAdd());
                $sale->setTotal($saleOfWeek->getTotal());
                $sale->setPet($saleOfWeek->getPet());
                $sale->setCustomer($saleOfWeek->getCustomer());
                $salesOfWeekCollection[] = $sale;
            }

            $weeklySales->setSales($salesOfWeekCollection);
            $weeklySales->setNumberOfSales(\count($salesOfWeek));
            $weeklySales->setBusinessDays($businessDays);

            try {
                $weeklySales->setDailyAverage($salesByWeek['total'] / $businessDays);
            } catch (\Throwable $exception) {
                $weeklySales->setDailyAverage(0.0);
            }

            $weeklySalesCollection[] = $weeklySales;
        }

        return $weeklySalesCollection;
    }

    /**
     * @return MonthlySales[]
     */
    public function getMonthlySales(\DateTime $reportDateFrom, \DateTime $reportDateTo): array
    {
        $salesGroupedByMonth = $this->saleManager->findByRangeDateGroupedByMonth($reportDateFrom, $reportDateTo);
        $monthlySalesCollection = [];

        foreach ($salesGroupedByMonth as $salesByMonth) {
            $year = $salesByMonth['year'];
            $month = $salesByMonth['month'];

            $monthlySales = new MonthlySales();
            $monthlySales->setTotal($salesByMonth['total']);
            $monthlySales->setMonth($month);
            $monthlySales->setYear($year);
            $firstMonthDate = (new \DateTime("first day of $year-$month"))->setTime(0, 0);
            $lastMonthDate = (new \DateTime("last day of $year-$month"))->setTime(23, 59, 59);

            $salesOfMonth = $this->saleManager->findByDateRange($firstMonthDate, $lastMonthDate);
            $salesOfMonthCollection = [];

            $currentDay = null;
            $currentWeek = null;
            $businessDays = 0;
            $businessWeeks = 0;

            foreach ($salesOfMonth as $saleOfMonth) {
                $saleOfMonthDay = (int)($saleOfMonth->getDateAdd())->format('N');
                $saleOfMonthWeek = (int)($saleOfMonth->getDateAdd())->format('W');

                if ($saleOfMonthDay !== $currentDay) {
                    $currentDay = $saleOfMonthDay;
                    $businessDays++;
                }

                if ($saleOfMonthWeek !== $currentWeek) {
                    $currentWeek = $saleOfMonthWeek;
                    $businessWeeks++;
                }

                $sale = new Sale();
                $sale->setId($saleOfMonth->getId());
                $sale->setDate($saleOfMonth->getDateAdd());
                $sale->setTotal($saleOfMonth->getTotal());
                $sale->setPet($saleOfMonth->getPet());
                $sale->setCustomer($saleOfMonth->getCustomer());
                $salesOfMonthCollection[] = $sale;
            }

            $monthlySales->setSales($salesOfMonthCollection);
            $monthlySales->setNumberOfSales(\count($salesOfMonth));
            $monthlySales->setBusinessDays($businessDays);
            $monthlySales->setBusinessWeeks($businessWeeks);
            $monthlySales->setDailyAverage($salesByMonth['total'] / $businessDays);
            $monthlySales->setWeeklyAverage($salesByMonth['total'] / $businessWeeks);

            $monthlySalesCollection[] = $monthlySales;
        }

        return $monthlySalesCollection;
    }
}