<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Form\PetType;
use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/edit/{id}', name: 'admin_pet_edit', methods: ['GET', 'POST'])]
class Edit extends AbstractController
{
    protected const FROM_SHOW = 'show';
    protected const SHOW_URL = '/admin/pet/show';

    public function __construct(private readonly PetManager $petManager)
    {}

    public function __invoke(Request $request, Pet $pet): Response
    {
        $pathIndex = $request->get('pathIndex');
        $pathFrom = $request->get('pathFrom');
        $backPath = $this->handleBackPath($pathIndex, $pathFrom, $pet->getId());

        $form = $this->createForm(PetType::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('edit-'.$pet->getId(), $request->request->get('_token'))) {
            $pet = $form->getData();
            $this->petManager->save($pet);

            $this->addFlash('success','Se han guardado los cambios correctamente');

            if ($pathFrom === self::FROM_SHOW) {
                return $this->render('admin/pet/show.html.twig', [
                    'pet' => $pet,
                    'path_index' => $pathIndex,
                ]);
            }

            return $this->redirect($backPath);
        }

        return $this->render('admin/pet/edit.html.twig', [
            'pet' => $pet,
            'form' => $form,
            'path_index' => $pathIndex,
            'path_from' => $pathFrom,
            'back_path' => $backPath,
        ]);
    }

    private function handleBackPath($pathIndex, $from, $petId): string
    {
        if ($from === self::FROM_SHOW) {
            return self::SHOW_URL.'/'.$petId;
        }

        return $pathIndex;
    }
}