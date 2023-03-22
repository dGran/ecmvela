<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Manager\SaleManager;
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
    ) {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function __invoke(Request $request): Response
    {
        $dateFrom = new \DateTime();
        $dateFrom->setTime(0,0);
        $dateTo = new \DateTime('+1 days');
        $dateTo->setTime(0,0);

        $todaySales = $this->saleManager->getTotalByDateRange($dateFrom, $dateTo);

        $dateFrom->modify('-1 days');
        $dateTo->modify('-1 days');
        $yesterdaySales = $this->saleManager->getTotalByDateRange($dateFrom, $dateTo);

        return $this->render('admin/dashboard.html.twig', [
            'today_sales' => $todaySales,
            'yesterday_sales' => $yesterdaySales,
        ]);
    }
}