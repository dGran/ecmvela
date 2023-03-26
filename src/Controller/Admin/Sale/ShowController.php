<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/{sale}/show', name: 'admin_sale_show', methods: ['GET'])]
class ShowController extends AbstractController
{
    public function __invoke(Request $request, Sale $sale): Response
    {
        return $this->render('modal/admin/sale/_show-modal-content.html.twig', [
            'sale' => $sale,
        ]);
    }
}
