<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Manager\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/create', name: 'admin_customer_create', methods: ['GET', 'POST'])]
class Create extends AbstractController
{
    public function __construct(
        private readonly CustomerManager $customerManager,
    ) {

    }

    public function __invoke(Request $request): Response
    {
        dump('nuevo cliente');die;
    }
}