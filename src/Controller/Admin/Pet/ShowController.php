<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/{pet}/show', name: 'admin_pet_show', methods: ['GET'])]
class ShowController extends AbstractController
{
    public function __invoke(Pet $pet): Response
    {
        return $this->render('modal/admin/pet/_show-modal-content.html.twig', [
            'pet' => $pet,
        ]);
    }
}