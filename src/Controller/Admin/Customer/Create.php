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

#[Route('/admin/customer/create', name: 'admin_customer_create', methods: ['GET', 'POST'])]
class Create extends AbstractController
{
    public function __construct(private readonly CustomerManager $customerManager)
    {}

    public function __invoke(Request $request): Response
    {
        $pathIndex = $request->get('pathIndex');

        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create', $request->request->get('_token'))) {
            $customer = $form->getData();
            $this->customerManager->save($customer);

            $this->addFlash('success','Se ha creado el nuevo cliente correctamente');

            return $this->redirect($pathIndex);
        }

        return $this->render('admin/customer/create.html.twig', [
            'customer' => $customer,
            'form' => $form,
            'path_index' => $pathIndex,
        ]);
    }
}