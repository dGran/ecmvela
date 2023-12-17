<?php

declare(strict_types=1);

namespace App\Controller\Admin\Booking;

use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking/create', name: 'admin_booking_create', methods: ['POST'])]
class CreateController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $date = $request->request->get('date');
        $bookingDate = null;

        if ($date) {
            $bookingDate = new \DateTime($date);
        }

        $booking = new Booking();

        if ($bookingDate) {
            $booking->setDate($bookingDate);
        }

        $form = $this->createForm(BookingType::class, $booking, [
            'action' => $this->generateUrl('admin_booking_store'),
            'method' => 'POST',
        ]);

        return $this->render('modal/admin/booking/_create-modal-content.html.twig', [
            'booking' => $booking,
            'form' => $form->createView(),
        ]);
    }
}
