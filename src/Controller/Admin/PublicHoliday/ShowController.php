<?php

declare(strict_types=1);

namespace App\Controller\Admin\PublicHoliday;

use App\Entity\PublicHoliday;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/public-holiday/{publicHoliday}/show', name: 'admin_public_holiday_show', methods: ['GET'])]
class ShowController extends AbstractController
{
    public function __invoke(PublicHoliday $publicHoliday): Response
    {
        return $this->render('modal/admin/public_holiday/_show-modal-content.html.twig', [
            'public_holiday' => $publicHoliday,
        ]);
    }
}