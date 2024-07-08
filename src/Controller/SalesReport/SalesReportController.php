<?php

declare(strict_types=1);

namespace App\Controller\SalesReport;

use App\Entity\PaymentMethod;
use App\Manager\SaleManager;
use App\Manager\SalePaymentManager;
use App\Services\SaleService;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class SalesReportController extends AbstractController
{
    private SalePaymentManager $salePaymentManager;

    private SaleManager $saleManager;

    private SaleService $saleService;

    private LoggerInterface $logger;

    public function __construct(
        SalePaymentManager $salePaymentManager,
        SaleManager $saleManager,
        SaleService $saleService,
        LoggerInterface $logger
    ) {
        $this->salePaymentManager = $salePaymentManager;
        $this->saleManager = $saleManager;
        $this->saleService = $saleService;
        $this->logger = $logger;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws \Exception
     */
    #[Route('/admin/sales-report', name: 'admin_sales_report', methods: ['GET', 'POST'])]
    public function index(Request $request, SessionInterface $session): Response
    {
        $dateRange = $this->getDateRange($request);
        $dateFrom = $dateRange['dateFrom'];
        $dateTo = $dateRange['dateTo'];

        if ($dateTo < $dateFrom) {
            $dateTo = (clone $dateFrom)->setTime(23, 59, 59);
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

        $salesToDeclare = $this->salePaymentManager->getSaleByDateRangeAndPaymentMethodNotCash($dateFrom, $dateTo);
        $exportSales = [];
        $totalTotalWithoutTaxes = 0;
        $totalTotalTaxes = 0;
        $totalTotal = 0;
        $saleCounter = 204;

        foreach ($salesToDeclare as $saleToDeclare) {
            $sale = $this->saleManager->findOneById($saleToDeclare['id']);

            if (null === $sale) {
                $this->logger->critical(\date(DATE_W3C).' - Sale not found with Id: '.$saleToDeclare['id']);

                continue;
            }

            $calculateSaleTotals = $this->saleService->calculateSaleTotals($sale);

            $saleIndex = match (true) {
                $saleCounter > 99 => 'V240',
                $saleCounter > 9 => 'V2400',
                default => 'V24000',
            };

            $invoice = $saleIndex.(string) $saleCounter;
            $exportSales[] = [
                'id' => $saleToDeclare['id'],
                'date' => $saleToDeclare['dateAdd'],
                'invoice' => $invoice,
                'total_without_taxes' => $calculateSaleTotals['total_without_taxes'],
                'total_taxes' => $calculateSaleTotals['total_taxes'],
                'total' => $calculateSaleTotals['total'],
            ];

            $totalTotalWithoutTaxes += $calculateSaleTotals['total_without_taxes'];
            $totalTotalTaxes += $calculateSaleTotals['total_taxes'];
            $totalTotal += $calculateSaleTotals['total'];

            ++$saleCounter;
        }

        $declarationTotals = [
            'total_without_taxes' => $totalTotalWithoutTaxes,
            'total_taxes' => $totalTotalTaxes,
            'total' => $totalTotal,
        ];

        $session->set('export_sales', $exportSales);

        return $this->render('admin/sales_report/index.html.twig', [
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'total_bizum' => $totalBizum,
            'total_card' => $totalCard,
            'total_cash' => $totalCash,
            'total_to_declare' => $totalToDeclare,
            'export_sales' => $exportSales,
            'declaration_totals' => $declarationTotals,
        ]);
    }

    /**
     * @throws WriterNotOpenedException
     * @throws IOException
     */
    #[Route('/admin/export-sales-report', name: 'admin_sales_report_export', methods: ['GET'])]
    public function export(SessionInterface $session): Response
    {
        $exportSales = $session->get('export_sales', []);
        $filename = date('Y-m-d_H-i-s').'_custom_sales_report'.'.csv';
        $filePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        $writer = WriterEntityFactory::createCSVWriter();
        $writer->openToFile($filePath);

        $headerRow = WriterEntityFactory::createRowFromArray(['Id', 'Fecha', 'N/Factura', 'Base imponible', 'Total IVA', 'Total']);
        $writer->addRow($headerRow);

        foreach ($exportSales as $sale) {
            $date = $sale['date'] instanceof \DateTime ? $sale['date']->format('Y-m-d H:i:s') : $sale['date'];

            $row = WriterEntityFactory::createRowFromArray([
                $sale['id'],
                $date,
                $sale['invoice'],
                \number_format($sale['total_without_taxes'], 2, ',', '.'),
                \number_format($sale['total_taxes'], 2, ',', '.'),
                \number_format($sale['total'], 2, ',', '.'),
            ]);
            $writer->addRow($row);
        }

        $writer->close();

        return new BinaryFileResponse($filePath, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * @return array{dateFrom: \DateTime, dateTo: \DateTime}
     *
     * @throws \Exception
     */
    private function getDateRange(Request $request): array
    {
        if (
            (null === $request->get('dateFrom') || '' === $request->get('dateFrom'))
            || (null === $request->get('dateTo') || '' === $request->get('dateTo'))
        ) {
            $currentDate = (new \DateTime())->setTime(0, 0);
            $quarter = ceil($currentDate->format('n') / 3);
            $year = $currentDate->format('Y');

            $dateFrom = (new \DateTime($year.'-'.(($quarter - 1) * 3 + 1).'-01'))->setTime(0, 0);
            $dateTo = clone $dateFrom;
            $dateTo->modify('+2 months')->modify('last day of this month')->setTime(23, 59, 59);

            return [
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
            ];
        }

        $dateFrom = (new \DateTime($request->get('dateFrom')))->setTime(0, 0);
        $dateTo = (new \DateTime($request->get('dateTo')))->setTime(23, 59, 59);

        return [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];
    }
}
