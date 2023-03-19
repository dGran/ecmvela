<?php

declare(strict_types=1);

namespace App\Model\View;

use App\Entity\Sale;
use App\Model\SalePaymentInfo;

class SaleEditView
{
    protected ?Sale $sale = null;
    protected ?SalePaymentInfo $salePaymentInfo = null;
    protected ?array $taxTypes = null;
    protected ?array $customers = null;
    protected ?array $pets = null;

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): SaleEditView
    {
        $this->sale = $sale;

        return $this;
    }

    public function getSalePaymentInfo(): ?SalePaymentInfo
    {
        return $this->salePaymentInfo;
    }

    public function setSalePaymentInfo(?SalePaymentInfo $salePaymentInfo): SaleEditView
    {
        $this->salePaymentInfo = $salePaymentInfo;

        return $this;
    }

    public function getTaxTypes(): ?array
    {
        return $this->taxTypes;
    }

    public function setTaxTypes(?array $taxTypes): SaleEditView
    {
        $this->taxTypes = $taxTypes;

        return $this;
    }

    public function getCustomers(): ?array
    {
        return $this->customers;
    }

    public function setCustomers(?array $customers): SaleEditView
    {
        $this->customers = $customers;

        return $this;
    }

    public function getPets(): ?array
    {
        return $this->pets;
    }

    public function setPets(?array $pets): SaleEditView
    {
        $this->pets = $pets;

        return $this;
    }
}