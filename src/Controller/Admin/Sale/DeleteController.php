<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\Manager\SaleLineManager;
use App\Manager\SaleManager;
use App\Manager\SalePaymentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/delete/{id}', name: 'admin_sale_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    public function __construct(
        private readonly SaleManager $saleManager,
        private readonly SaleLineManager $saleLineManager,
        private readonly SalePaymentManager $salePaymentManager
    ) {}

    public function __invoke(Request $request, Sale $sale): Response
    {
        if ($this->isCsrfTokenValid('delete-'.$sale->getId(), $request->request->get('_token'))) {
            $this->saleLineManager->deleteFromSale($sale);
            $this->salePaymentManager->deleteFromSale($sale);
            $this->saleManager->delete($sale);
            $this->addFlash('success','El TPV se ha eliminado correctamente');
        }

        return $this->redirect($request->get('pathIndex'));
    }
}