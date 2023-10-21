<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale\Ajax;

use App\Entity\Sale;
use App\Manager\SaleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateDateController extends AbstractController
{
    private SaleManager $saleManager;

    public function __construct(SaleManager $saleManager)
    {
        $this->saleManager = $saleManager;
    }

    #[Route('/admin/sale/{sale}/update-date', name: 'admin_sale_update_date', methods: ['POST'])]
    public function __invoke(Request $request, Sale $sale): JsonResponse
    {
        if ($sale->isLocked()) {
            $this->addFlash('error','El ticket esta bloqueado y no se puede editar');

            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        try {
            $dateAdd = new \DateTime($request->request->get('date'));
            $sale->setDateAdd($dateAdd);

            $this->saleManager->update($sale);
        } catch (\Exception $exception) {
            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return new JsonResponse([Response::HTTP_OK]);
    }
}
