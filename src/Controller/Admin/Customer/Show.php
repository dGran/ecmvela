<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/ver/{id}', name: 'admin_customer_show', methods: ['GET'])]
class Show extends AbstractController
{
    public function __invoke(Customer $customer): Response
    {
        return $this->render('admin/customer/show.html.twig', [
            'customer' => $customer,
        ]);
    }
}