<?php

declare(strict_types=1);

namespace App\Controller\Admin\Pet;

use App\Entity\Pet;
use App\Manager\PetManager;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pet/delete/{pet}', name: 'admin_pet_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    private PetManager $petManager;

    public function __construct(PetManager $petManager)
    {
        $this->petManager = $petManager;
    }

    public function __invoke(Request $request, Pet $pet): Response
    {
        if ($pet->getProfileImg()) {
            $currentImg = $this->getParameter('kernel.project_dir').'/public/'.$pet->getProfileImgPath();

            if (\strpos($currentImg, 'broken_image')) {
                unset($currentImg);
            }
        }

        try {
            $this->petManager->delete($pet);
            $this->addFlash('success', 'La mascota se ha eliminado correctamente');
        } catch (ForeignKeyConstraintViolationException $exception) {
            $this->addFlash('error','No es posible eliminar mascotas con tickets, elimina los tickets primero o desactiva la mascota');
        } catch (\Throwable $exception) {
            $this->addFlash('error','Error interno del servidor'.$exception->getMessage());
        }

        if (!empty($currentImg) && \file_exists($currentImg)) {
            unlink($currentImg);
        }

        return $this->redirect($request->get('redirect'));
    }
}
