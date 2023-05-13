<?php

declare(strict_types=1);

namespace App\Controller\Admin\Dashboard;

use App\View\DashboardViewManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_dashboard', methods: 'GET')]
class DashboardController extends AbstractController
{
    public function __construct(private readonly DashboardViewManager $dashboardViewManager)
    {
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $dateFrom = new \DateTime('2023-01-01 0:00:00');
        $dateTo = new \DateTime('2023-06-30 23:59:59');

        $view = $this->dashboardViewManager->build($dateFrom, $dateTo);

//        $totalBizum = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod($dateFrom, $dateTo, PaymentMethod::BIZUM_METHOD_ID);
//        $totalCard = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod($dateFrom, $dateTo, PaymentMethod::CARD_METHOD_ID);
//        $totalCash = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod($dateFrom, $dateTo, PaymentMethod::CASH_METHOD_ID);


        return $this->render('admin/dashboard.html.twig', [
            'view' => $view,
//            'total_bizum' => $totalBizum,
//            'total_card' => $totalCard,
//            'total_cash' => $totalCash,
        ]);
    }
}