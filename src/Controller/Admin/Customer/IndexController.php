<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer;

use App\Manager\CustomerManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer', name: 'admin_customer', methods: ['GET'])]
class IndexController extends AbstractController
{
    private CustomerManager $customerManager;
    private PaginatorInterface $paginator;

    public function __construct(CustomerManager $customerManager, PaginatorInterface $paginator)
    {
        $this->customerManager = $customerManager;
        $this->paginator = $paginator;
    }

    public function __invoke(Request $request): Response
    {
        $queryParams = [
            'search' => $request->query->get('search'),
            'sort' => $request->query->get('sort') ?? 'id',
            'direction' => $request->query->get('direction') ?? 'DESC',
        ];

        $data = $this->customerManager->findBy([], [$queryParams['sort'] => $queryParams['direction']]);

        if (!empty($queryParams['search'])) {
            $data = $this->customerManager->findByIndexSearchFields($queryParams['search'], $queryParams['sort'], $queryParams['direction']);
        }

        $customers = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render('admin/customer/index.html.twig', [
            'customers' => $customers,
            'filter_search' => $queryParams['search'],
        ]);
    }
}
