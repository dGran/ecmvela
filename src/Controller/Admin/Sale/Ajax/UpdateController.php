<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale\Ajax;

use App\Entity\Sale;
use App\Manager\CustomerManager;
use App\Manager\PetManager;
use App\Manager\SaleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController extends AbstractController
{
    public function __construct(
        private readonly SaleManager $saleManager,
        private readonly CustomerManager $customerManager,
        private readonly PetManager $petManager
    ) {}

    #[Route('/admin/sale/{sale}/update', name: 'admin_sale_update', methods: ['POST'])]
    public function __invoke(Request $request, Sale $sale): JsonResponse
    {
        try {
            $dateAdd = new \DateTime($request->request->get('date'));
            $sale->setDateAdd($dateAdd);
            $sale->setPet($this->petManager->findOneById((int)$request->get('pet')));
            $sale->setCustomer($this->customerManager->findOneById((int)$request->get('customer')));
            $sale->setNotes((string)$request->get('notes'));
            $sale->setMaintenancePlan($request->get('maintenancePlan') === "true");

            $this->saleManager->update($sale);
        } catch (\Exception $exception) {
            throw new \RuntimeException();
        }

        if (!empty($sale->getCustomer())) {
            //find customerByPet
            $customers = $this->customerManager->findBy([], ['name' => 'asc']);
        }

        if (!empty($sale->getCustomer())) {
            //find petsByCustomer
            $pets = $this->petManager->findBy([], ['name' => 'asc']);

            if (empty($sale->getPet())) {

            }

            $customers = $this->customerManager->findBy([], ['name' => 'asc']);
        }

        $pets = $this->petManager->findBy([], ['name' => 'asc']);

        return new JsonResponse([
            'sale' => $sale,
            'pets' => $pets,
            'customers' => $customers,
        ]);
    }
}