<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Manager\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/edit/{id}', name: 'admin_customer_edit', methods: ['GET', 'POST'])]
class Edit extends AbstractController
{
    protected const FROM_SHOW = 'show';
    protected const SHOW_URL = '/admin/customer/show';

    public function __construct(private readonly CustomerManager $customerManager)
    {}

    public function __invoke(Request $request, Customer $customer): Response
    {
        $pathIndex = $request->get('pathIndex');
        $pathFrom = $request->get('pathFrom');
        $backPath = $this->handleBackPath($pathIndex, $pathFrom, $customer->getId());

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('edit-'.$customer->getId(), $request->request->get('_token'))) {
            $customer = $form->getData();
            $this->customerManager->save($customer);

            $this->addFlash('success','Se han guardado los cambios correctamente');

            if ($pathFrom === self::FROM_SHOW) {
                return $this->render('admin/customer/show.html.twig', [
                    'customer' => $customer,
                    'path_index' => $pathIndex,
                ]);
            }

            return $this->redirect($backPath);
        }

        return $this->render('admin/customer/edit.html.twig', [
            'customer' => $customer,
            'form' => $form,
            'path_index' => $pathIndex,
            'path_from' => $pathFrom,
            'back_path' => $backPath,
        ]);
    }

    private function handleBackPath($pathIndex, $from, $customerId): string
    {
        if ($from === self::FROM_SHOW) {
            return self::SHOW_URL.'/'.$customerId;
        }

        return $pathIndex;
    }
}