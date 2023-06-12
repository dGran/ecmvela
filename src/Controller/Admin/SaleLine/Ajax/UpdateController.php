<?php

declare(strict_types=1);

namespace App\Controller\Admin\SaleLine\Ajax;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Manager\SaleLineManager;
use App\Manager\TaxTypeManager;
use App\Services\SaleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    private SaleLineManager $saleLineManager;
    private TaxTypeManager $taxTypeManager;
    private SaleService $saleService;

    public function __construct(SaleLineManager $saleLineManager, TaxTypeManager $taxTypeManager, SaleService $saleService)
    {
        $this->saleLineManager = $saleLineManager;
        $this->taxTypeManager = $taxTypeManager;
        $this->saleService = $saleService;
    }

    #[Route('/admin/sale/{sale}/edit/{saleLine}/update-line', name: 'admin_sale_edit_update_line', methods: ['POST'])]
    public function __invoke(Request $request, Sale $sale, SaleLine $saleLine): JsonResponse
    {
        if ($sale->isLocked()) {
            $this->addFlash('error','El ticket esta bloqueado y no se puede editar');

            return new JsonResponse([Response::HTTP_OK]);
        }

        try {
            $saleLine->setQuantity((int)$request->get('quantity'));
            $saleLine->setTitle((string)$request->get('title'));
            $saleLine->setPrice((float)$request->get('price'));
            $saleLine->setDiscount((float)$request->get('discount'));
            $saleLine->setTaxType($this->taxTypeManager->findOneById((int)$request->get('taxType')));
            $saleLine->setMaintenancePlan($request->get('maintenancePlan') === "true");

            $this->saleLineManager->update($saleLine);
            $this->saleService->updateSaleLineTotal($saleLine);
            $this->saleService->updateSaleTotals($sale);
        } catch (\Exception $exception) {
            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return new JsonResponse([
            'total_line' => $saleLine->getTotal(),
        ]);
    }
}