<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Entity\Sale;
use App\Manager\CustomerManager;
use App\Manager\PetManager;
use App\Manager\TaxTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale/{id}/edit', name: 'admin_sale_edit', methods: ['GET', 'POST'])]
class EditController extends AbstractController
{
    public function __construct(
        private readonly TaxTypeManager $taxTypeManager,
        private readonly CustomerManager $customerManager,
        private readonly PetManager $petManager
    ) {
    }

    public function __invoke(Request $request, Sale $sale): Response
    {
        $pathIndex = $request->get('pathIndex');

        $taxTypes = $this->taxTypeManager->findBy([], ['rate' => 'asc']);
        $customers = $this->customerManager->findBy([], ['name' => 'asc']);
        $pets = $this->petManager->findBy([], ['name' => 'asc']);

        return $this->render('admin/sale/edit.html.twig', [
            'sale' => $sale,
            'path_index' => $pathIndex,
            'tax_types' => $taxTypes,
            'customers' => $customers,
            'pets' => $pets,
        ]);
    }
}