<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Entity\TaxType;
use App\Manager\SaleLineManager;
use App\Manager\SaleManager;
use App\Manager\TaxTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/create', name: 'admin_sale_create', methods: ['GET', 'POST'])]
class CreateController extends AbstractController
{
    private SaleManager $saleManager;
    private SaleLineManager $saleLineManager;
    private TaxTypeManager $taxTypeManager;

    public function __construct(SaleManager $saleManager, SaleLineManager $saleLineManager, TaxTypeManager $taxTypeManager)
    {
        $this->saleManager = $saleManager;
        $this->saleLineManager = $saleLineManager;
        $this->taxTypeManager = $taxTypeManager;
    }

    public function __invoke(Request $request): Response
    {
        $pathIndex = $request->get('pathIndex');

        $sale = new Sale();
        $sale->setTotalDiscounts(0.0);
        $sale->setTotalWithoutTaxes(0.0);
        $sale->setTotalTaxes(0.0);
        $sale->setTotal(0.0);
        $sale->setDateAdd(new \DateTime());
        $this->saleManager->save($sale);

        $saleLine = new SaleLine();
        $saleLine->setSale($sale);
        $saleLine->setDateAdd(new \DateTime());
        $saleLine->setQuantity(1);
        $saleLine->setPrice(0.0);
        $saleLine->setDiscount(0.0);
        $saleLine->setTotal(0.0);
        $saleLine->setTaxType($this->taxTypeManager->findOneById(TaxType::TAXT_TYPE_GENERAL_ID));
        $this->saleLineManager->save($saleLine);

        return $this->redirectToRoute('admin_sale_edit', [
            'id' => $sale->getId(),
            'pathIndex' => $pathIndex,
        ]);
    }
}