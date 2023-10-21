<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use App\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/{customer}/edit', name: 'admin_customer_edit', methods: ['POST'])]
class EditController extends AbstractController
{
    public function __invoke(Request $request, Customer $customer): Response
    {
        $form = $this->createForm(CustomerType::class, $customer, [
            'action' => $this->generateUrl('admin_customer_update', ['customer' => $customer->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/customer/_edit-modal-content.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }
}
