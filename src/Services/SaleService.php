<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Manager\SaleLineManager;
use App\Manager\SaleManager;

class SaleService
{
    public function __construct(
        private readonly SaleManager $saleManager,
        private readonly SaleLineManager $saleLineManager,
    ) {}

    public function updateSaleLineTotal(SaleLine $saleLine): void
    {
        $saleLine->setTotal((float) $this->calculateSaleLineTotals($saleLine)['total']);

        $this->saleLineManager->update($saleLine);
    }

    public function updateSaleTotals(Sale $sale): void
    {
        $sale->setTotalDiscounts((float) $this->calculateSaleTotals($sale)['total_discounts']);
        $sale->setTotalWithoutTaxes((float) $this->calculateSaleTotals($sale)['total_without_taxes']);
        $sale->setTotalTaxes((float) $this->calculateSaleTotals($sale)['total_taxes']);
        $sale->setTotal((float) $this->calculateSaleTotals($sale)['total']);

        $this->saleManager->update($sale);
    }

    /**
     * @return array{total_discount: string, float, total_without_taxes: string, float, total_taxes: string, float, total: string, float}
     */
    private function calculateSaleLineTotals(SaleLine $saleLine): array
    {
        $discountMultiplier = (100 - $saleLine->getDiscount()) / 100;
        $finalPrice = $saleLine->getPrice() * $discountMultiplier;
        $total = $saleLine->getQuantity() * $finalPrice;
        $totalWithoutTaxes = $total / (1 + ($saleLine->getTaxType()->getRate() / 100));
        $totalTaxes = $total - $totalWithoutTaxes;
        $totalDiscount = $saleLine->getQuantity() * $saleLine->getPrice() * (1 - $discountMultiplier);

        return [
            'total_discount' => $totalDiscount,
            'total_without_taxes' => $totalWithoutTaxes,
            'total_taxes' => $totalTaxes,
            'total' => $total,
        ];
    }

    /**
     * @return array{total_without_taxes: string, float, total_taxes: string, float, total: string, float}
     */
    private function calculateSaleTotals(Sale $sale): array
    {
        $totalDiscounts = 0.0;
        $totalWithoutTaxes = 0.0;
        $totalTaxes = 0.0;
        $total = 0.0;

        foreach ($sale->getSaleLines() as $saleLine) {
            $lineTotals = $this->calculateSaleLineTotals($saleLine);
            $totalDiscounts += $lineTotals['total_discount'];
            $totalWithoutTaxes += $lineTotals['total_without_taxes'];
            $totalTaxes += $lineTotals['total_taxes'];
            $total += $lineTotals['total'];
        }

        return [
            'total_discounts' => $totalDiscounts,
            'total_without_taxes' => $totalWithoutTaxes,
            'total_taxes' => $totalTaxes,
            'total' => $total,
        ];
    }

    public function getPaymentState(Sale $sale)
    {
        if (empty($sale->getSalePayments())) {
            return Sale::STATE_PENDING_PAYMENT;
        }

        $totalAmount = $sale->getTotal();
        $totalPaid = 0.0;

        foreach ($sale->getSalePayments() as $payment) {
            $totalPaid += $payment->getAmount();
        }

        switch ($totalPaid) {
            case 0:
                return SALE::STATE_PENDING_PAYMENT;
            case $totalPaid < $totalAmount:
                return SALE::STATE_PARTIAL_PAYMENT;
            case $totalAmount:
                return SALE::STATE_PAID;
        }
    }

    public function getTotalPaid(Sale $sale): ?float
    {
        $totalPaid = 0.0;

        foreach ($sale->getSalePayments() as $payment) {
            $totalPaid += $payment->getAmount();
        }

        return $totalPaid;
    }
}