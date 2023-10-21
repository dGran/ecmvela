<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Form\PetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/create', name: 'admin_pet_create', methods: ['POST'])]
class CreateController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $pet = new Pet();
        $form = $this->createForm(PetType::class, $pet, [
            'action' => $this->generateUrl('admin_pet_store'),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/pet/_create-modal-content.html.twig', [
            'pet' => $pet,
            'form' => $form->createView(),
        ]);
    }
}
