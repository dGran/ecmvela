<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Form\PetType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/{pet}/edit', name: 'admin_pet_edit', methods: ['POST'])]
class EditController extends AbstractController
{
    public function __invoke(Request $request, Pet $pet): Response
    {
        $form = $this->createForm(PetType::class, $pet, [
            'action' => $this->generateUrl('admin_pet_update', ['pet' => $pet->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/pet/_edit-modal-content.html.twig', [
            'pet' => $pet,
            'form' => $form->createView(),
        ]);
    }
}
