<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday;

use App\Entity\PublicHoliday;
use App\Form\PublicHolidayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/public-holiday/create', name: 'admin_public_holiday_create', methods: ['POST'])]
class CreateController extends AbstractController
{
    public function __invoke(Request $request): Response
    {
        $publicHoliday = new PublicHoliday();
        $form = $this->createForm(PublicHolidayType::class, $publicHoliday, [
            'action' => $this->generateUrl('admin_public_holiday_store'),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/public_holiday/_create-modal-content.html.twig', [
            'public_holiday' => $publicHoliday,
            'form' => $form->createView(),
        ]);
    }
}
