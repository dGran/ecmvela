<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday\Ajax;

use App\Entity\PublicHoliday;
use App\Form\PublicHolidayType;
use App\Manager\PublicHolidayManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/publicHoliday/{publicHoliday}/update', name: 'admin_public_holiday_update', methods: ['POST'])]
class UpdateController extends AbstractController
{
    private PublicHolidayManager $publicHolidayManager;

    public function __construct(PublicHolidayManager $publicHolidayManager)
    {
        $this->publicHolidayManager = $publicHolidayManager;
    }

    public function __invoke(Request $request, PublicHoliday $publicHoliday): JsonResponse
    {
        $form = $this->createForm(PublicHolidayType::class, $publicHoliday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicHoliday = $form->getData();

            try {
                $this->publicHolidayManager->save($publicHoliday);
            } catch (\Throwable $exception) {
                $this->addFlash('error','Ya existe un festivo para la fecha seleccionada');
            }

            $this->addFlash('success','El festivo se ha actualizado correctamente');

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
