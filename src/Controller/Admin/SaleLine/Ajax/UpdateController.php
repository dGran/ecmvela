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
    public function __construct(
        private readonly SaleLineManager $saleLineManager,
        private readonly TaxTypeManager $taxTypeManager,
        private readonly SaleService $saleService,
    ) {}

    #[Route('/admin/sale/{sale}/edit/{saleLine}/update-line', name: 'admin_sale_edit_update_line', methods: ['POST'])]
    public function __invoke(Request $request, Sale $sale, SaleLine $saleLine): JsonResponse
    {
        try {
            $saleLine->setQuantity((int)$request->request->get('quantity'));
            $saleLine->setTitle((string)$request->request->get('title'));
            $saleLine->setPrice((float)$request->request->get('price'));
            $saleLine->setDiscount((float)$request->request->get('discount'));
            $saleLine->setTaxType($this->taxTypeManager->findOneById((int)$request->request->get('taxType')));

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