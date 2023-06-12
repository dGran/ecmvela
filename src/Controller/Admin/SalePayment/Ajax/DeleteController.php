<?php

declare(strict_types=1);

namespace App\Controller\Admin\SalePayment\Ajax;

use App\Entity\Sale;
use App\Entity\SalePayment;
use App\Manager\SalePaymentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    private SalePaymentManager $salePaymentManager;

    public function __construct(SalePaymentManager $salePaymentManager)
    {
        $this->salePaymentManager = $salePaymentManager;
    }

    #[Route('/admin/sale/{sale}/edit/{salePayment}/delete-payment', name: 'admin_sale_edit_delete_payment', methods: ['GET'])]
    public function __invoke(Sale $sale, SalePayment $salePayment): JsonResponse
    {
        try {
            $this->salePaymentManager->delete($salePayment);
        } catch (\Exception $exception) {
            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return new JsonResponse([Response::HTTP_OK]);
    }
}