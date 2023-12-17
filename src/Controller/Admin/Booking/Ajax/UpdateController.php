<?php

declare(strict_types=1);

namespace App\Controller\Admin\Booking\Ajax;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Manager\BookingManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking/{booking}/update', name: 'admin_booking_update', methods: ['POST'])]
class UpdateController extends AbstractController
{
    private BookingManager $bookingManager;

    public function __construct(BookingManager $bookingManager)
    {
        $this->bookingManager = $bookingManager;
    }

    public function __invoke(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking = $form->getData();
            $this->bookingManager->save($booking);

            $this->addFlash('success','La cita se ha actualizado correctamente');

            return $this->redirectToRoute('admin_booking', [
                'view' => 'day',
                'day' => $booking->getDate()->format('Y-m-d'),
            ]);
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
