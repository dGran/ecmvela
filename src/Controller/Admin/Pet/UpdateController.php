<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Form\PetType;
use App\Helper\Slugify;
use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/{pet}/update', name: 'admin_pet_update', methods: ['POST'])]
class UpdateController extends AbstractController
{
    public function __construct(private readonly PetManager $petManager, private readonly Slugify $slugger)
    {}

    public function __invoke(Request $request, Pet $pet): JsonResponse
    {
        $form = $this->createForm(PetType::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pet = $form->getData();
            $this->handleUploadedFile($form, $pet, $request->get('deleteImage') === "true");
            $pet->setActive($request->get('active') === "on");
            $this->petManager->update($pet);

            $this->addFlash('success','La mascota se ha actualizado correctamente');

            return new JsonResponse(['status' => 'success',]);
        }

        return new JsonResponse([
            'status' => 'error',
            'errors' => $this->getErrorsFromForm($form),
        ]);
    }

    private function handleUploadedFile(FormInterface $form, Pet $pet, bool $deleteImage): void
    {
        if ($deleteImage) {
            $pet->setProfileImg(null);

            return;
        }

        $uploadedFile = $form['imageFile']->getData();

        if ($uploadedFile) {
            $destination = $this->getParameter('kernel.project_dir').'/public/'.$pet->getProfileImgDir();
            $filename = $this->slugger->slugify($pet->getName()).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($destination, $filename);

            if ($pet->getProfileImg()) {
                $currentImg = $this->getParameter('kernel.project_dir').'/public/'.$pet->getProfileImgPath();

                if (\file_exists($currentImg)) {
                    unlink($currentImg);
                }
            }

            $pet->setProfileImg($filename);
        }
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