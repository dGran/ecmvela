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

#[Route('/admin/sales-report', name: 'admin_sales_report', methods: ['GET', 'POST'])]
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
        if ($request->get('dateFrom') === null || $request->get('dateTo') === null) {
            $currentDate = (new \DateTime())->setTime(0, 0);
            $quarter = ceil($currentDate->format('n') / 3);
            $year = $currentDate->format('Y');

            $dateFrom = (new \DateTime($year . '-' . (($quarter - 1) * 3 + 1) . '-01'))->setTime(0, 0);
            $dateTo = clone $dateFrom;
            ($dateTo->modify('+2 months')->modify('last day of this month'))->setTime(23, 59, 59);
        }

        if ($request->get('dateFrom') !== null) {
            $dateFrom = (new \DateTime($request->get('dateFrom')))->setTime(0, 0);
        }

        if ($request->get('dateTo') !== null) {
            $dateTo = (new \DateTime($request->get('dateTo')))->setTime(23, 59, 59);
        }

        $totalBizum = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod(
            $dateFrom,
            $dateTo,
            PaymentMethod::BIZUM_METHOD_ID
        );
        $totalCard = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod(
            $dateFrom,
            $dateTo,
            PaymentMethod::CARD_METHOD_ID
        );
        $totalCash = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethod(
            $dateFrom,
            $dateTo,
            PaymentMethod::CASH_METHOD_ID
        );

        $totalToDeclare = $this->salePaymentManager->getTotalByDateRangeAndPaymentMethodNotCash($dateFrom, $dateTo);

        $saleListTotDeclare = $this->salePaymentManager->getSaleByDateRangeAndPaymentMethodNotCash($dateFrom, $dateTo);
        $exportSales = [];
        $saleCounter = 88;

        foreach ($saleListTotDeclare as $sale) {
            $saleIndex = match (true) {
                $saleCounter > 99 => 'V230',
                $saleCounter > 9 => 'V2300',
                default => 'V23000',
            };

            $invoice = $saleIndex.(string)$saleCounter;
            $exportSales[] = [
                'id' => $sale['id'],
                'date' => $sale['dateAdd'],
                'invoice' => $invoice,
                'total_without_taxes' => $sale['totalWithoutTaxes'],
                'total_taxes' => $sale['totalTaxes'],
                'total' => $sale['total'],
            ];

            $saleCounter++;
        }

        return $this->render('admin/sales_report/index.html.twig', [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'total_bizum' => $totalBizum,
            'total_card' => $totalCard,
            'total_cash' => $totalCash,
            'total_to_declare' => $totalToDeclare,
            'export_sales' => $exportSales,
        ]);
    }
}