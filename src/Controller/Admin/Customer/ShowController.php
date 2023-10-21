<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/{customer}/show', name: 'admin_customer_show', methods: ['GET'])]
class ShowController extends AbstractController
{
    public function __invoke(Customer $customer): Response
    {
        return $this->render('modal/admin/customer/_show-modal-content.html.twig', [
            'customer' => $customer,
        ]);
    }
}
