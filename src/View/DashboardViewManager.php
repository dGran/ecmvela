<?php

declare(strict_types=1);

namespace App\View;

use App\Manager\SaleManager;
use App\Model\SaleTotal;
use App\Model\SaleTotalDay;
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

        $sales = $this->saleManager->findAllGroupedByDay();

        $saleTotalDays = [];
        $total = 0;

        foreach ($sales as $sale) {
            $saleTotalDay = new SaleTotalDay();
            $saleTotalDay->setTotal($sale['total']);
            $saleTotalDay->setDay(new \DateTime($sale['day']));

            $saleTotalDays[] = $saleTotalDay;
            $total += $sale['total'];
        }

        $saleTotal = new SaleTotal();
        $saleTotal->setDays($saleTotalDays);
        $saleTotal->setTotal($total);

        $view->setSaleTotal($saleTotal);

        return $view;
    }
}
