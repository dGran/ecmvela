<?php

declare(strict_types=1);

namespace App\View;

use App\Entity\Sale;
use App\Manager\CustomerManager;
use App\Manager\PetManager;
use App\Manager\TaxTypeManager;
use App\Model\SalePaymentInfo;
use App\Model\View\SaleEditView;
use App\Services\SaleService;

class SaleEditViewManager
{
    public function __construct(
        private readonly TaxTypeManager $taxTypeManager,
        private readonly CustomerManager $customerManager,
        private readonly PetManager $petManager,
        private readonly SaleService $saleService
    ) {
    }

    public function build(Sale $sale): SaleEditView
    {
        $view = new SaleEditView();
        $view->setSale($sale);

        $salePaymentInfo = new SalePaymentInfo();
        $salePaymentInfo->setState($this->saleService->getPaymentState($sale));
        $salePaymentInfo->setTotalPaid($this->saleService->getTotalPaid($sale));
        $view->setSalePaymentInfo($salePaymentInfo);

        $view->setCustomers($this->customerManager->findBy([], ['name' => 'asc']));
        $view->setPets($this->petManager->findBy([], ['name' => 'asc']));
        $view->setTaxTypes($this->taxTypeManager->findBy([], ['rate' => 'asc']));

        return $view;
    }
}
