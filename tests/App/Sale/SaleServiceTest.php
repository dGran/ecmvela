<?php

declare(strict_types=1);

namespace App\Sale;

use App\Entity\SaleLine;
use App\Entity\TaxType;
use App\Manager\SaleLineManager;
use App\Manager\SaleManager;
use App\Services\SaleService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SaleServiceTest extends TestCase
{
    private SaleManager&MockObject $saleManager;

    private SaleLineManager&MockObject $saleLineManager;

    protected function setUp(): void
    {
        $this->saleManager = $this->getMockBuilder(SaleManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->saleLineManager = $this->getMockBuilder(SaleLineManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @dataProvider provideSaleLine
     *
     * @param array{total_discounts: float, total_without_taxes: float, total_taxes: float, total: float} $expectedTotals
     *
     * @throws \ReflectionException
     */
    public function testCalculateSaleLineTotals(SaleLine $saleLine, array $expectedTotals): void
    {
        $saleService = new SaleService($this->saleManager, $this->saleLineManager);

        $reflectionClass = new \ReflectionClass(SaleService::class);
        $reflectionMethod = $reflectionClass->getMethod('calculateSaleLineTotals');

        $result = $reflectionMethod->invoke($saleService, $saleLine);

        self::assertIsArray($result);
        self::assertArrayHasKey('total_discount', $result);
        self::assertArrayHasKey('total_without_taxes', $result);
        self::assertArrayHasKey('total_taxes', $result);
        self::assertArrayHasKey('total', $result);
        self::assertIsFloat($result['total_discount']);
        self::assertIsFloat($result['total_without_taxes']);
        self::assertIsFloat($result['total_taxes']);
        self::assertIsFloat($result['total']);
        self::assertEquals($expectedTotals['total_discount'], round($result['total_discount'], 2));
        self::assertEquals($expectedTotals['total_without_taxes'], round($result['total_without_taxes'], 2));
        self::assertEquals($expectedTotals['total_taxes'], round($result['total_taxes'], 2));
        self::assertEquals($expectedTotals['total'], round($result['total'], 2));
    }

    private function provideSaleLine(): \Iterator
    {
        $taxRate = 21;
        $quantity = 1;
        $price = 30;
        $discount = 20;

        $expectedTotals = [
            'total_discount' => 6.00,
            'total_without_taxes' => 19.83,
            'total_taxes' => 4.17,
            'total' => 24.00,
        ];

        yield 'Sale line with discount' => [
            'sale line' => $this->getSaleLine($quantity, $price, $discount, $taxRate),
            'expected totals' => $expectedTotals,
        ];

        $quantity = 2;
        $price = 50;
        $discount = 0;

        $expectedTotals = [
            'total_discount' => 0.00,
            'total_without_taxes' => 82.64,
            'total_taxes' => 17.36,
            'total' => 100.00,
        ];

        yield 'Sale line without discount' => [
            'sale line' => $this->getSaleLine($quantity, $price, $discount, $taxRate),
            'expected totals' => $expectedTotals,
        ];
    }

    private function getSaleLine(int $quantity, float $price, float $discount, float $taxRate): SaleLine
    {
        $saleLine = new SaleLine();
        $saleLine->setQuantity($quantity);
        $saleLine->setPrice($price);
        $saleLine->setDiscount($discount);
        $taxType = new TaxType();
        $taxType->setRate($taxRate);
        $saleLine->setTaxType($taxType);

        return $saleLine;
    }
}
