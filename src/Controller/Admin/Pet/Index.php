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
class Index extends AbstractController
{
    public function __construct(private readonly PetManager $petManager, private readonly PaginatorInterface $paginator)
    {}

    public function __invoke(Request $request): Response
    {
        $data = $this->petManager->findAll();
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