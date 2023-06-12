<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Manager\PetManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet', name: 'admin_pet', methods: ['GET', 'POST'])]
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
        $data = $this->petManager->findBy([], ['id' => 'DESC']);
        $search = $request->get('search');

        if (!empty($search)) {
            $data = $this->petManager->findByIndexSearchFields($search);
        }

        $pets = $this->paginator->paginate($data, $request->query->getInt('page', 1), 10);

        return $this->render('admin/pet/index.html.twig', [
            'pets' => $pets,
            'search' => $search,
        ]);
    }
}