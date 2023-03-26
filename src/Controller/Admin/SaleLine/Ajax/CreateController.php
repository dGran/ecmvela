<?php

declare(strict_types=1);

namespace App\Controller\Admin\SaleLine\Ajax;

use App\Entity\Sale;
use App\Entity\SaleLine;
use App\Entity\TaxType;
use App\Manager\SaleLineManager;
use App\Manager\TaxTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    public function __construct(
        private readonly SaleLineManager $saleLineManager,
        private readonly TaxTypeManager $taxTypeManager
    ) {}

    #[Route('/admin/sale/{sale}/edit/add-line', name: 'admin_sale_edit_add_line', methods: ['GET'])]
    public function __invoke(Sale $sale): Response
    {
        $saleLine = (new SaleLine())
            ->setSale($sale)
            ->setQuantity(1)
            ->setPrice(0.0)
            ->setDiscount(0.0)
            ->setTotal(0.0)
            ->setTaxType($this->taxTypeManager->findOneById(TaxType::TAXT_TYPE_GENERAL_ID))
            ->setDateAdd(new \DateTime())
        ;

        try {
            $this->saleLineManager->save($saleLine);
        } catch (\Exception $exception) {
            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return $this->render('admin/sale/_sale-detail-line.html.twig', [
            'sale' => $sale,
            'saleLine' => $saleLine,
            'tax_types' => $this->taxTypeManager->findBy([], ['rate' => 'asc'])
        ]);
    }
}