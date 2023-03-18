<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\pet;
use App\Manager\PetManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/delete/{id}', name: 'admin_pet_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    public function __construct(private readonly PetManager $petManager)
    {}

    public function __invoke(Request $request, pet $pet): Response
    {
        if ($this->isCsrfTokenValid('delete-'.$pet->getId(), $request->request->get('_token'))) {
            //        TODO: comprobar si las mascota tiene relaciones

            if ($pet->getProfileImg()) {
                $currentImg = $this->getParameter('kernel.project_dir').'/public/'.$pet->getProfileImgPath();

                if (\file_exists($currentImg)) {
                    unlink($currentImg);
                }
            }

            $this->petManager->delete($pet);
            $this->addFlash('success','La mascota se ha eliminado correctamente');
        }

        return $this->redirect($request->get('pathIndex'));
    }
}