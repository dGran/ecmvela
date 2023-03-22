<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Manager\SaleManager;
use App\View\DashboardViewManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_dashboard', methods: 'GET')]
class DashboardController extends AbstractController
{
    public function __construct(
        private readonly SaleManager $saleManager,
        private readonly DashboardViewManager $dashboardViewManager
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function __invoke(Request $request): Response
    {
        $start = (date('D') !== 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d');
        $finish = (date('D') !== 'Sun') ? date('Y-m-d', strtotime('next Sunday')) : date('Y-m-d');

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

        return $this->render('admin/dashboard.html.twig', [
            'view' => $view,
        ]);
    }
}