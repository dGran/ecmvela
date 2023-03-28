<?php

declare(strict_types=1);

namespace App\View;

use App\Manager\SaleManager;
use App\Model\SaleTotalDays;
use App\Model\SaleTotalDay;
use App\Model\SaleTotalWeek;
use App\Model\SaleTotalWeeks;
use App\Model\View\DashboardView;

class DashboardViewManager
{
    public function __construct(
        private readonly SaleManager $saleManager,
    ) {
    }

    public function build(): DashboardView
    {
        $view = new DashboardView();


        /**
         * unica query groupedByDay
         * recorrer ese array y montar un array con todos los datos, day, dayOfWeek, Week, Year
         * con ese array ya se podria generar cualquier modelo para la vista
         */

        $salesGroupedByDay = $this->saleManager->findAllGroupedByDay();

        $saleTotalDays = [];
        $total = 0;

        foreach ($salesGroupedByDay as $sale) {
            $saleTotalDay = new SaleTotalDay();
            $saleTotalDay->setTotal($sale['total']);
            $saleTotalDay->setTickets($sale['tickets']);
            $saleTotalDay->setDay(new \DateTime($sale['day']));

            $saleTotalDays[] = $saleTotalDay;
            $total += $sale['total'];
        }

        $saleTotalDaysModel = new SaleTotalDays();
        $saleTotalDaysModel->setDays($saleTotalDays);
        $saleTotalDaysModel->setTotal($total);

        $view->setSaleTotalDays($saleTotalDaysModel);



        $salesGroupedByWeek = $this->saleManager->findAllGroupedByWeek();

        $saleTotalWeeks = [];
        $total = 0;

        foreach ($salesGroupedByWeek as $sale) {
            $weekNumber = $sale['week'];
            $date = new \DateTime();
            $startDate = $date->setISODate((int)$date->format('o'), $weekNumber, 1);
            $date = new \DateTime();
            $endDate = $date->setISODate((int)$date->format('o'), $weekNumber, 7);

            $saleTotalWeek = new SaleTotalWeek();
            $saleTotalWeek->setTotal($sale['total']);
            $saleTotalWeek->setWeek($sale['week']);
            $saleTotalWeek->setStartDate($startDate);
            $saleTotalWeek->setEndDate($endDate);

            $saleTotalWeeks[] = $saleTotalWeek;
            $total += $sale['total'];
        }

        $saleTotalWeeksModel = new SaleTotalWeeks();
        $saleTotalWeeksModel->setWeeks($saleTotalWeeks);
        $saleTotalWeeksModel->setTotal($total);

        $view->setSaleTotalWeeks($saleTotalWeeksModel);

        return $view;
    }
}
