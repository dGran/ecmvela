<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer/show/{id}', name: 'admin_customer_show', methods: ['GET', 'POST'])]
class ShowController extends AbstractController
{
    public function __invoke(Request $request, Customer $customer): Response
    {
        $pathIndex = $request->get('pathIndex');

        return $this->render('admin/customer/show.html.twig', [
            'customer' => $customer,
            'path_index' => $pathIndex,
        ]);
    }
}