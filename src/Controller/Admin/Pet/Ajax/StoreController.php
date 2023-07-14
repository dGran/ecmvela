<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet\Ajax;

use App\Entity\Pet;
use App\Form\PetType;
use App\Helper\Slugify;
use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/save', name: 'admin_pet_store', methods: ['POST'])]
class StoreController extends AbstractController
{
    private PetManager $petManager;
    private Slugify $slugger;

    public function __construct(PetManager $petManager, Slugify $slugger)
    {
        $this->petManager = $petManager;
        $this->slugger = $slugger;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $form = $this->createForm(PetType::class, new Pet());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pet = $form->getData();
            $uploadedFile = $form['imageFile']->getData();

            if ($uploadedFile !== null) {
                $destination = $this->getParameter('kernel.project_dir').'/public/'.$pet->getProfileImgDir();
                $filename = $this->slugger->slugify($pet->getName()).'-'.uniqid('', true).'.'.$uploadedFile->guessExtension();
                $uploadedFile->move($destination, $filename);

                $pet->setProfileImg($filename);
            }

            $pet->setActive($request->get('active') === "on");
            $this->petManager->save($pet);

            $this->addFlash('success','La mascota se ha creado correctamente');

            return new JsonResponse(['status' => 'success',]);
        }

        return new JsonResponse([
            'status' => 'error',
            'errors' => $this->getErrorsFromForm($form),
        ]);
    }

    private function getErrorsFromForm($form): array
    {
        $errors = [];

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorsFromForm($child);
            }
        }

        return $errors;
    }
}
