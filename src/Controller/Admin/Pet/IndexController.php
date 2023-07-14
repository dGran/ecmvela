<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Manager\PetManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet', name: 'admin_pet', methods: ['GET'])]
class IndexController extends AbstractController
{
    private PetManager $petManager;
    private PaginatorInterface $paginator;

    public function __construct(PetManager $petManager, PaginatorInterface $paginator)
    {
        $this->petManager = $petManager;
        $this->paginator = $paginator;
    }

    public function __invoke(Request $request): Response
    {
        $queryParams = [
            'search' => $request->query->get('search'),
            'sort' => $request->query->get('sort') ?? 'id',
            'direction' => $request->query->get('direction') ?? 'DESC',
        ];

        $data = $this->petManager->findBy([], [$queryParams['sort'] => $queryParams['direction']]);

        if (!empty($queryParams['search'])) {
            $data = $this->petManager->findByIndexSearchFields($queryParams['search'], $queryParams['sort'], $queryParams['direction']);
        }

        $pets = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render('admin/pet/index.html.twig', [
            'pets' => $pets,
            'filter_search' => $queryParams['search'],
        ]);
    }
}