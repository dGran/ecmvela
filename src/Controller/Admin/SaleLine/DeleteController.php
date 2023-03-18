<?php

declare(strict_types=1);

namespace App\Controller\Admin\SaleLine;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Manager\SaleLineManager;
use App\Manager\TaxTypeManager;
use App\Services\SaleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(
        private readonly SaleLineManager $saleLineManager,
        private readonly TaxTypeManager $taxTypeManager,
        private readonly SaleService $saleService
    ) {}

    #[Route('/admin/sale/{sale}/edit/{saleLine}/delete-line', name: 'admin_sale_edit_delete_line', methods: ['GET'])]
    public function __invoke(Sale $sale, SaleLine $saleLine): Response
    {
        $taxTypes = $this->taxTypeManager->findBy([], ['rate' => 'asc']);

        if ($sale->getSaleLines()->count() === 1) {
            return new JsonResponse(Response::HTTP_NOT_ACCEPTABLE);
        }

        try {
            $this->saleLineManager->delete($saleLine);
            $this->saleService->updateSaleTotals($sale);
        } catch (\Exception $exception) {
            throw new \RuntimeException();
        }

        return $this->render('admin/sale/_sale-detail.html.twig', [
            'sale' => $sale,
            'tax_types' => $taxTypes,
        ]);
    }
}