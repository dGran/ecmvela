<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\Manager\SaleManager;
use App\Manager\SalePaymentManager;
use App\View\DashboardViewManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[Route('/admin', name: 'admin_dashboard', methods: 'GET')]
class DashboardController extends AbstractController
{
    public function __construct(
        private readonly SaleManager $saleManager,
        private readonly SalePaymentManager $salePaymentManager,
        private readonly DashboardViewManager $dashboardViewManager,
        private readonly ChartBuilderInterface $chartBuilder
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function __invoke(Request $request): Response
    {
//        $start = (date('D') !== 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
//        $finish = (date('D') !== 'Sun') ? date('Y-m-d', strtotime('next Sunday')) : date('Y-m-d');

//        dump($start, $finish);die;

        $view = $this->dashboardViewManager->build();

//
//        $dateFrom = new \DateTime();
//        $dateFrom->setTime(0,0);
//        $dateTo = new \DateTime('+1 days');
//        $dateTo->setTime(0,0);
//
//        $todaySales = $this->saleManager->getTotalByDateRange($dateFrom, $dateTo);
//
//        $dateFrom->modify('-1 days');
//        $dateTo->modify('-1 days');
//        $yesterdaySales = $this->saleManager->getTotalByDateRange($dateFrom, $dateTo);


        $dateFrom = new \DateTime('2023-04-01 0:00:00');
        $dateTo = new \DateTime('2023-06-30 23:59:59');
        $totalBizum = $this->salePaymentManager->getTotalBizumPaymentMethodByRangeDates($dateFrom, $dateTo);
        $totalCash = $this->salePaymentManager->getTotalCashPaymentMethodByRangeDates($dateFrom, $dateTo);

        $saleTotalWeeks = $view->getSaleTotalWeeks()->getWeeks();
        $saleTotalWeeksTotal = [];
        $saleTotalWeeksTotalEstimated = [];
        $saleTotalWeeksWeek = [];

        foreach ($saleTotalWeeks as $saleTotalWeek) {
            $startDate = $saleTotalWeek->getStartDate()->format('d-m');
            $endDate = $saleTotalWeek->getEndDate()->format('d-m');
            $saleTotalWeeksWeek[] = $startDate.' / '.$endDate;
            $saleTotalWeeksTotal[] = $saleTotalWeek->getTotal();
            $saleTotalWeeksTotalEstimated[] = 500;
        }

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $saleTotalWeeksWeek,
            'datasets' => [
                [
                    'label' => 'Ventas por semanas',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $saleTotalWeeksTotal,
                ],
                [
                    'label' => 'Ventas estimadas',
                    'backgroundColor' => 'rgb(217, 119, 6)',
                    'borderColor' => 'rgb(217, 119, 6)',
                    'data' => $saleTotalWeeksTotalEstimated,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('admin/dashboard.html.twig', [
            'view' => $view,
            'total_bizum' => $totalBizum,
            'total_cash' => $totalCash,
            'chart' => $chart,
        ]);
    }
}