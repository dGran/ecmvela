<?php

declare(strict_types=1);

namespace App\Controller\Admin\Customer\Ajax;

use App\Manager\CustomerManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/service/customer/search', name: 'admin_service_customer_search', methods: ['GET'])]
class SearchController extends AbstractController
{
    public function __construct(private readonly CustomerManager $customerManager, private readonly PaginatorInterface $paginator)
    {
    }

    public function __invoke(Request $request): Response
    {
        $query = $request->query->get('search');

        $data = $this->customerManager->findAll();

        if (\strlen($query) > 2) {
            $data = $this->customerManager->findByName($query);
        }

        $customers = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

//        if (empty($customers)) {
//            return new JsonResponse('empty');
//        }
//
//        return new JsonResponse($customers);

        return $this->render('admin/customer/index/_data.html.twig', [
            'customers' => $customers,
        ]);
    }
}