<?php

declare(strict_types=1);

namespace App\View;

use App\Entity\PaymentMethod;
use App\Model\SalePaymentInfo;
use App\Model\View\SalesIndexView;
use App\Services\SaleService;
use Knp\Component\Pager\Pagination\PaginationInterface;

class SalesIndexViewManager
{
    public function __construct(private readonly SaleService $saleService)
    {}

    public function build(PaginationInterface $sales, ?string $search): SalesIndexView
    {
        $view = new SalesIndexView();
        $view->setSearch($search);
        $view->setSales($sales);

        $paymentsInfo = [];

        foreach ($sales as $sale) {
            $paymentInfo = new SalePaymentInfo();
            $paymentInfo->setState($this->saleService->getPaymentState($sale));
            $paymentInfo->setTotalPaid($this->saleService->getTotalPaid($sale));

            $allCash = true;

            foreach ($sale->getSalePayments() as $payment) {
                if ($payment->getPaymentMethod()->getId() !== PaymentMethod::CASH_METHOD_ID) {
                    $allCash = false;
                }
            }

            $paymentInfo->setAllCash($allCash);

            $paymentsInfo[$sale->getId()] = $paymentInfo;
        }

        $view->setPaymentsInfo($paymentsInfo);

        return $view;
    }
}
