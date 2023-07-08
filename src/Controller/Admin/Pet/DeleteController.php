<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\pet;
use App\Manager\PetManager;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/delete/{id}', name: 'admin_pet_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    private PetManager $petManager;

    public function __construct(PetManager $petManager)
    {
        $this->petManager = $petManager;
    }

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

            try {
                $this->petManager->delete($pet);
                $this->addFlash('success','La mascota se ha eliminado correctamente');
            } catch (ForeignKeyConstraintViolationException $exception) {
                $this->addFlash('error','No se puede eliminar..., existen tickets para la mascota, en su lugar puedes desactivar');
            }
        }

        return $this->redirect($request->get('pathIndex'));
    }
}