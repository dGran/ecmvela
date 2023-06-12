<?php

declare(strict_types=1);

namespace App\Controller\SalesReport;

use App\Entity\PaymentMethod;
use App\Manager\SalePaymentManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sales-report', name: 'admin_sales_report', methods: 'GET')]
class SalesReportController extends AbstractController
{
    private SalePaymentManager $salePaymentManager;

    public function __construct(SalePaymentManager $salePaymentManager)
    {
        $this->salePaymentManager = $salePaymentManager;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $dateFrom = new \DateTime('2023-06-01 0:00:00');
        $dateTo = new \DateTime('2023-06-30 23:59:59');

        $totalBizum = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod($dateFrom, $dateTo, PaymentMethod::BIZUM_METHOD_ID);
        $totalCard = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod($dateFrom, $dateTo, PaymentMethod::CARD_METHOD_ID);
        $totalCash = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod($dateFrom, $dateTo, PaymentMethod::CASH_METHOD_ID);


        return $this->render('admin/sales_report/index.html.twig', [
            'total_bizum' => $totalBizum,
            'total_card' => $totalCard,
            'total_cash' => $totalCash,
        ]);
    }
}