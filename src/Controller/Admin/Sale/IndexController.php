<?php

declare(strict_types=1);

namespace App\Controller\Admin\Sale;

use App\Manager\SaleManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/sale', name: 'admin_sale', methods: ['GET', 'POST'])]
class IndexController extends AbstractController
{
    private const DEFAULT_PER_PAGE = 20;
    public function __construct(private readonly SaleManager $saleManager, private readonly PaginatorInterface $paginator)
    {}

    public function __invoke(Request $request): Response
    {
        $data = $this->saleManager->findBy([], ['dateAdd' => 'DESC']);
        $search = $request->get('search');

        if (!empty($search)) {
//            $data = $this->saleManager->findByIndexSearchFields($search);
        }

        $sales = $this->paginator->paginate($data, $request->query->getInt('page', 1), self::DEFAULT_PER_PAGE);

        return $this->render('admin/sale/index.html.twig', [
            'sales' => $sales,
            'search' => $search,
        ]);
    }
}