<?php

declare(strict_types=1);

namespace App\Controller\Admin\SaleLine\Ajax;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Manager\SaleLineManager;
use App\Services\SaleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(
        private readonly SaleLineManager $saleLineManager,
        private readonly SaleService $saleService
    ) {}

    #[Route('/admin/sale/{sale}/edit/{saleLine}/delete-line', name: 'admin_sale_edit_delete_line', methods: ['GET'])]
    public function __invoke(Sale $sale, SaleLine $saleLine): JsonResponse
    {
        $saleLineId = $saleLine->getId();

        if ($sale->getSaleLines()->count() === 1) {
            return new JsonResponse(Response::HTTP_NOT_ACCEPTABLE);
        }

        try {
            $this->saleLineManager->delete($saleLine);
            $this->saleService->updateSaleTotals($sale);
        } catch (\Exception $exception) {
            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return new JsonResponse($saleLineId);
    }
}