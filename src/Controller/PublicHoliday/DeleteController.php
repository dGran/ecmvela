<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday;

use App\Entity\PublicHoliday;
use App\Manager\PublicHolidayManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/public-holiday/{publicHoliday}/delete', name: 'admin_public_holiday_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    private PublicHolidayManager $publicHolidayManager;

    public function __construct(PublicHolidayManager $publicHolidayManager)
    {
        $this->publicHolidayManager = $publicHolidayManager;
    }

    public function __invoke(Request $request, PublicHoliday $publicHoliday): Response
    {
        try {
            $this->publicHolidayManager->delete($publicHoliday);
            $this->addFlash('success', 'El festivo se ha eliminado correctamente');
        } catch (\Throwable $exception) {
            $this->addFlash('error','Error interno del servidor'.$exception->getMessage());
        }

        return $this->redirect($request->get('redirect'));
    }
}
