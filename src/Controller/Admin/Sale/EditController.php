<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\View\SaleEditViewManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/{id}/edit', name: 'admin_sale_edit', methods: ['GET', 'POST'])]
class EditController extends AbstractController
{
    public function __construct(private readonly SaleEditViewManager $saleEditViewManager)
    {}

    public function __invoke(Request $request, Sale $sale): Response
    {
        $pathIndex = $request->get('pathIndex');

        $view = $this->saleEditViewManager->build($sale);

        return $this->render('admin/sale/edit.html.twig', [
            'view' => $view,
            'path_index' => $pathIndex,
        ]);
    }
}