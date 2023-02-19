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

#[Route('/admin/pet/create', name: 'admin_pet_create', methods: ['GET', 'POST'])]
class Create extends AbstractController
{
    public function __construct(private readonly PetManager $petManager)
    {}

    public function __invoke(Request $request): Response
    {
        $pathIndex = $request->get('pathIndex');

        $pet = new Pet();
        $form = $this->createForm(PetType::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create', $request->request->get('_token'))) {
            $pet = $form->getData();

            $uploadedFile = $form['imageFile']->getData();

            if ($uploadedFile) {
                $uploadedFile = $form['imageFile']->getData();
                $destination = $this->getParameter('kernel.project_dir').'/public/img/dogs';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $this->slugger->slugify($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination,$newFilename);

                $dog->setProfileImg($newFilename);
            }
            $this->petManager->save($pet);

            $this->addFlash('success','Se han guardado los cambios correctamente');

            return $this->redirect($pathIndex);
        }

        return $this->render('admin/pet/create.html.twig', [
            'pet' => $pet,
            'form' => $form,
            'path_index' => $pathIndex,
        ]);
    }
}