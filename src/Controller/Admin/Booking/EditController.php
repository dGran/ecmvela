<?php

declare(strict_types=1);

namespace App\Controller\Admin\Booking;

use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking/{booking}/edit', name: 'admin_booking_edit', methods: ['POST'])]
class EditController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking, [
            'action' => $this->generateUrl('admin_booking_update', ['booking' => $booking->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/booking/_edit-modal-content.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }
}
