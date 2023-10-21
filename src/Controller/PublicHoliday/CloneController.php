<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday;

use App\Entity\PublicHoliday;
use App\Manager\PublicHolidayManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/public-holiday/{publicHoliday}/clone', name: 'admin_public_holiday_clone', methods: ['GET'])]
class CloneController extends AbstractController
{
    private PublicHolidayManager $publicHolidayManager;

    public function __construct(PublicHolidayManager $publicHolidayManager)
    {
        $this->publicHolidayManager = $publicHolidayManager;
    }

    public function __invoke(PublicHoliday $publicHoliday): Response
    {
        $clonedPublicHoliday = $this->publicHolidayManager->create();
        $clonedPublicHoliday->setName($publicHoliday->getName());
        $date = clone $publicHoliday->getDate();
        $date->modify('+1 year');
        $clonedPublicHoliday->setDate($date);

        try {
            $this->publicHolidayManager->save($clonedPublicHoliday);
        } catch (\Throwable $exception) {
            $this->addFlash('error','Ya existe un festivo para la fecha seleccionada');
        }

        return $this->redirectToRoute('admin_public_holiday');
    }
}
