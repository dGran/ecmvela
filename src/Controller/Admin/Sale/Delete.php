<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\Manager\SaleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/delete/{id}', name: 'admin_sale_delete', methods: ['POST'])]
class Delete extends AbstractController
{
    public function __construct(private readonly SaleManager $saleManager)
    {}

    public function __invoke(Request $request, Sale $sale): Response
    {
        if ($this->isCsrfTokenValid('delete-'.$sale->getId(), $request->request->get('_token'))) {
            //        TODO: comprobar si el cliente tiene relaciones

            $this->saleManager->delete($sale);
            $this->addFlash('success','El cliente se ha eliminado correctamente');
        }

        return $this->redirect($request->get('pathIndex'));
    }
}