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
    private SaleManager $saleManager;
    private SaleLineManager $saleLineManager;
    private SalePaymentManager $salePaymentManager;

    public function __construct(SaleManager $saleManager, SaleLineManager $saleLineManager, SalePaymentManager $salePaymentManager) {
        $this->saleManager = $saleManager;
        $this->saleLineManager = $saleLineManager;
        $this->salePaymentManager = $salePaymentManager;
    }

    public function __invoke(Request $request, Sale $sale): Response
    {
        if ($sale->isLocked()) {
            $this->addFlash('error','El ticket esta bloqueado y no se puede eliminar');

            return $this->redirect($request->get('pathIndex'));
        }

        if ($this->isCsrfTokenValid('delete-'.$sale->getId(), $request->request->get('_token'))) {
            $this->saleLineManager->deleteFromSale($sale);
            $this->salePaymentManager->deleteFromSale($sale);
            $this->saleManager->delete($sale);
            $this->addFlash('success','El ticket se ha eliminado correctamente');
        }

        return $this->redirect($request->get('pathIndex'));
    }
}
