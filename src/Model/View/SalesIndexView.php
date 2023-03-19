<?php

declare(strict_types=1);

namespace App\Model\View;

use App\Model\SalePaymentInfo;
use Knp\Component\Pager\Pagination\PaginationInterface;

class SalesIndexView
{
    protected ?string $search;
    protected ?PaginationInterface $sales = null;
    /** @var SalePaymentInfo[]|null */
    protected ?array $paymentsInfo = null;

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): SalesIndexView
    {
        $this->search = $search;

        return $this;
    }

    public function getSales(): ?PaginationInterface
    {
        return $this->sales;
    }

    public function setSales(?PaginationInterface $sales): SalesIndexView
    {
        $this->sales = $sales;

        return $this;
    }

    public function getPaymentsInfo(): ?array
    {
        return $this->paymentsInfo;
    }

    public function setPaymentsInfo(?array $paymentsInfo): SalesIndexView
    {
        $this->paymentsInfo = $paymentsInfo;

        return $this;
    }
}