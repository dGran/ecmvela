<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Form\PetType;
use App\Helper\Slugify;
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

    public function __construct(private readonly PetManager $petManager, private readonly Slugify $slugger)
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
            $uploadedFile = $form['imageFile']->getData();

            if ($uploadedFile) {
                $uploadedFile = $form['imageFile']->getData();
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

            $this->petManager->save($pet);
            $this->addFlash('success','Se han guardado los cambios correctamente');

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

    private function handleBackPath($pathIndex, $from, $customerId): string
    {
        if ($from === self::FROM_SHOW) {
            return self::SHOW_URL.'/'.$customerId;
        }

        return $pathIndex;
    }
}