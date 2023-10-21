<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/create', name: 'admin_customer_create', methods: ['POST'])]
class CreateController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer, [
            'action' => $this->generateUrl('admin_customer_store'),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/customer/_create-modal-content.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }
}
