<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use App\Manager\CustomerManager;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/delete/{customer}', name: 'admin_customer_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    private CustomerManager $customerManager;

    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    public function __invoke(Request $request, Customer $customer): Response
    {
        try {
            $this->customerManager->delete($customer);
            $this->addFlash('success', 'El cliente se ha eliminado correctamente');
        } catch (ForeignKeyConstraintViolationException $exception) {
            $this->addFlash('error','No es posible eliminar clientes con tickets, elimina los tickets primero');
        } catch (\Throwable $exception) {
            $this->addFlash('error','Error interno del servidor'.$exception->getMessage());
        }

        return $this->redirect($request->get('redirect'));
    }
}