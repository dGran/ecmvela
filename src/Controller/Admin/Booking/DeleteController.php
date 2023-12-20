<?php

declare(strict_types=1);

namespace App\Controller\Admin\Booking;

use App\Entity\Booking;
use App\Manager\BookingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking/{booking}/delete', name: 'admin_booking_delete', methods: ['POST'])]
class DeleteController extends AbstractController
{
    private BookingManager $bookingManager;

    public function __construct(BookingManager $bookingManager)
    {
        $this->bookingManager = $bookingManager;
    }

    public function __invoke(Request $request, Booking $booking): Response
    {
        try {
            $this->bookingManager->delete($booking);
            $this->addFlash('success', 'La cita se ha eliminado correctamente');
        } catch (\Throwable $exception) {
            $this->addFlash('error','Error interno del servidor'.$exception->getMessage());
        }

        return $this->redirect($request->get('redirect'));
    }
}
