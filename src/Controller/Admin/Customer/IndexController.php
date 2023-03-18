<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Manager\CustomerManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer', name: 'admin_customer', methods: ['GET', 'POST'])]
class IndexController extends AbstractController
{
    public function __construct(private readonly CustomerManager $customerManager, private readonly PaginatorInterface $paginator)
    {}

    public function __invoke(Request $request): Response
    {
        $data = $this->customerManager->findBy([], ['dateAdd' => 'DESC']);
        $search = $request->get('search');

        if (!empty($search)) {
            $data = $this->customerManager->findByIndexSearchFields($search);
        }

        $customers = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render('admin/customer/index.html.twig', [
            'customers' => $customers,
            'search' => $search,
        ]);
    }
}