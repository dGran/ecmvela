<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\Form\SaleType;
use App\Manager\SaleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/create', name: 'admin_sale_create', methods: ['GET', 'POST'])]
class Create extends AbstractController
{
    public function __construct(private readonly SaleManager $saleManager)
    {}

    public function __invoke(Request $request): Response
    {
        $pathIndex = $request->get('pathIndex');

        $sale = new Sale();
        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create', $request->request->get('_token'))) {
            $sale = $form->getData();
            $this->saleManager->save($sale);

            $this->addFlash('success','Se ha creado el nuevo cliente correctamente');

            return $this->redirect($pathIndex);
        }

        return $this->render('admin/sale/create.html.twig', [
            'sale' => $sale,
            'form' => $form,
            'path_index' => $pathIndex,
        ]);
    }
}