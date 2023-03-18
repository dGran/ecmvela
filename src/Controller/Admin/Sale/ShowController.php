<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/show/{id}', name: 'admin_sale_show', methods: ['GET', 'POST'])]
class ShowController extends AbstractController
{
    public function __invoke(Request $request, Sale $sale): Response
    {
        $pathIndex = $request->get('pathIndex');

        return $this->render('admin/sale/show.html.twig', [
            'sale' => $sale,
            'path_index' => $pathIndex,
        ]);
    }
}