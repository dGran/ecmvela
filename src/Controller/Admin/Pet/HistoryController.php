<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Entity\Sale;
use App\Utils\Helper;
use App\Manager\SaleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/{pet}/sale-history', name: 'admin_pet_sale_history', methods: ['GET'])]
class HistoryController extends AbstractController
{
    private SaleManager $saleManager;
    private Helper $helper;

    public function __construct(SaleManager $saleManager, Helper $helper)
    {
        $this->saleManager = $saleManager;
        $this->helper = $helper;
    }

    public function __invoke(Pet $pet): Response
    {
        $saleHistory = $this->saleManager->findByPetId($pet->getId());

        if (!empty($saleHistory)) {
            /** @var Sale $lasSale */
            $lastSale = \current($saleHistory);
            $lastService = $this->helper->getDifferenceBetweenDates($lastSale->getDateAdd(), new \DateTime());
            $totalSales = 0.0;

            $differences = [];
            $previousDate = null;

            foreach ($saleHistory as $sale) {
                $totalSales += $sale->getTotal();

                if ($previousDate !== null && $sale->getDateAdd()) {
                    $diff = $sale->getDateAdd()->diff($previousDate)->days;
                    $differences[] = $diff;
                }

                $previousDate = $sale->getDateAdd();
            }

            try {
                $periodicity = \round(\array_sum($differences) / count($differences));
                $nextServiceAccordingPeriodicity = clone $lastSale->getDateAdd();
                $nextServiceAccordingPeriodicity->modify('+'.$periodicity.' days');
            } catch (\Throwable $exception) {
                $periodicity = null;
            }

            $saleAverage = $totalSales / \count($saleHistory);
        }

        return $this->render('modal/admin/pet/_history-modal-content.html.twig', [
            'pet' => $pet,
            'sale_history' => $saleHistory,
            'last_service' => $lastService ?? null,
            'sale_average' => $saleAverage ?? null,
            'periodicity' => $periodicity ?? null,
            'next_service_according_periodicity' => $nextServiceAccordingPeriodicity ?? null,
        ]);
    }
}
