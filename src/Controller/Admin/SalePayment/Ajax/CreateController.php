<?php

declare(strict_types=1);

namespace App\Controller\Admin\SalePayment\Ajax;

use App\Entity\Sale;
use App\Entity\SalePayment;
use App\Manager\PaymentMethodManager;
use App\Manager\SalePaymentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    private SalePaymentManager $salePaymentManager;
    private PaymentMethodManager $paymentMethodManager;

    public function __construct(SalePaymentManager $salePaymentManager, PaymentMethodManager $paymentMethodManager)
    {
        $this->salePaymentManager = $salePaymentManager;
        $this->paymentMethodManager = $paymentMethodManager;
    }

    #[Route('/admin/sale/{sale}/edit/add-payment', name: 'admin_sale_edit_add_payment', methods: ['POST'])]
    public function __invoke(Request $request, Sale $sale): JsonResponse
    {
        $salePayment = (new SalePayment())
            ->setSale($sale)
            ->setPaymentMethod($this->paymentMethodManager->findOneById((int)$request->request->get('paymentMethod')))
            ->setAmount((float)$request->request->get('amount'))
            ->setDateAdd(new \DateTime())
        ;

        try {
            $this->salePaymentManager->save($salePayment);
        } catch (\Exception $exception) {
            return new JsonResponse([Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

        return new JsonResponse([Response::HTTP_OK]);
    }
}
