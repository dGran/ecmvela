<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Form\PetType;
use App\Helper\Slugify;
use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/create', name: 'admin_pet_create', methods: ['GET', 'POST'])]
class CreateController extends AbstractController
{
    public function __construct(private readonly PetManager $petManager, private readonly Slugify $slugger)
    {}

    public function __invoke(Request $request): Response
    {
        $pathIndex = $request->get('pathIndex');

        $pet = new Pet();
        $form = $this->createForm(PetType::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $this->isCsrfTokenValid('create', $request->request->get('_token'))) {
            $pet = $form->getData();
            $this->handleUploadedFile($form, $pet);
            $this->petManager->save($pet);
            
            $this->addFlash('success','Se ha creado la nueva mascota correctamente');

            return $this->redirect($pathIndex);
        }

        return $this->render('admin/pet/create.html.twig', [
            'pet' => $pet,
            'form' => $form,
            'path_index' => $pathIndex,
        ]);
    }

    private function handleUploadedFile(FormInterface $form, Pet $pet): void
    {
        $uploadedFile = $form['imageFile']->getData();

        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir').'/public/'.$pet->getProfileImgDir();
            $filename = $this->slugger->slugify($pet->getName()).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($destination, $filename);

            $pet->setProfileImg($filename);
        }
    }
}