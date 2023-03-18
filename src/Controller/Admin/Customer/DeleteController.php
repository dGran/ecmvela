<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use App\Manager\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/delete/{id}', name: 'admin_customer_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    public function __construct(private readonly CustomerManager $customerManager)
    {}

    public function __invoke(Request $request, Customer $customer): Response
    {
        if ($this->isCsrfTokenValid('delete-'.$customer->getId(), $request->request->get('_token'))) {
            //        TODO: comprobar si el cliente tiene relaciones

            $this->customerManager->delete($customer);
            $this->addFlash('success','El cliente se ha eliminado correctamente');
        }

        return $this->redirect($request->get('pathIndex'));
    }
}