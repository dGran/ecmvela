<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday;

use App\Entity\PublicHoliday;
use App\Form\PublicHolidayType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/public-holiday/{publicHoliday}/edit', name: 'admin_public_holiday_edit', methods: ['POST'])]
class EditController extends AbstractController
{
    public function __invoke(Request $request, PublicHoliday $publicHoliday): Response
    {
        $form = $this->createForm(PublicHolidayType::class, $publicHoliday, [
            'action' => $this->generateUrl('admin_public_holiday_update', ['publicHoliday' => $publicHoliday->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/public_holiday/_edit-modal-content.html.twig', [
            'public_holiday' => $publicHoliday,
            'form' => $form->createView(),
        ]);
    }
}