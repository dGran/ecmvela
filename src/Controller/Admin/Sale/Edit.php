<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\Form\SaleType;
use App\Manager\SaleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/edit/{id}', name: 'admin_sale_edit', methods: ['GET', 'POST'])]
class Edit extends AbstractController
{
    protected const FROM_SHOW = 'show';
    protected const SHOW_URL = '/admin/sale/show';

    public function __construct(private readonly SaleManager $saleManager)
    {}

    public function __invoke(Request $request, Sale $sale): Response
    {
        $pathIndex = $request->get('pathIndex');
        $pathFrom = $request->get('pathFrom');
        $backPath = $this->handleBackPath($pathIndex, $pathFrom, $sale->getId());

        $form = $this->createForm(SaleType::class, $sale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('edit-'.$sale->getId(), $request->request->get('_token'))) {
            $sale = $form->getData();
            $this->saleManager->update($sale);

            $this->addFlash('success','Se ha actualizado el cliente correctamente');

            if ($pathFrom === self::FROM_SHOW) {
                return $this->render('admin/sale/show.html.twig', [
                    'sale' => $sale,
                    'path_index' => $pathIndex,
                ]);
            }

            return $this->redirect($backPath);
        }

        return $this->render('admin/sale/edit.html.twig', [
            'sale' => $sale,
            'form' => $form,
            'path_index' => $pathIndex,
            'path_from' => $pathFrom,
            'back_path' => $backPath,
        ]);
    }

    private function handleBackPath($pathIndex, $from, $saleId): string
    {
        if ($from === self::FROM_SHOW) {
            return self::SHOW_URL.'/'.$saleId;
        }

        return $pathIndex;
    }
}