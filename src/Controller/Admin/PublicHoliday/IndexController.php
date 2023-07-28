<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday;

use App\Manager\PublicHolidayManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/public-holiday', name: 'admin_public_holiday', methods: ['GET'])]
class IndexController extends AbstractController
{
    private PublicHolidayManager $publicHolidayManager;
    private PaginatorInterface $paginator;

    public function __construct(PublicHolidayManager $publicHolidayManager, PaginatorInterface $paginator)
    {
        $this->publicHolidayManager = $publicHolidayManager;
        $this->paginator = $paginator;
    }

    public function __invoke(Request $request): Response
    {
        $queryParams = [
            'search' => $request->query->get('search'),
            'sort' => $request->query->get('sort') ?? 'id',
            'direction' => $request->query->get('direction') ?? 'DESC',
        ];

        $data = $this->publicHolidayManager->findBy([], [$queryParams['sort'] => $queryParams['direction']]);

        if (!empty($queryParams['search'])) {
            $data = $this->publicHolidayManager->findByIndexSearchFields($queryParams['search'], $queryParams['sort'], $queryParams['direction']);
        }

        $publicHolidays = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render('admin/public_holiday/index.html.twig', [
            'public_holidays' => $publicHolidays,
            'filter_search' => $queryParams['search'],
        ]);
    }
}