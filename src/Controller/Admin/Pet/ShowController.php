<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/show/{id}', name: 'admin_pet_show', methods: ['GET', 'POST'])]
class ShowController extends AbstractController
{
    public function __invoke(Request $request, pet $pet): Response
    {
        $pathIndex = $request->get('pathIndex');

        return $this->render('admin/pet/show.html.twig', [
            'pet' => $pet,
            'path_index' => $pathIndex,
        ]);
    }
}