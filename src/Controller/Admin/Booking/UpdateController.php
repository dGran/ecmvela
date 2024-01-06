<?php

declare(strict_types=1);

namespace App\Controller\Admin\Booking;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Manager\BookingManager;
use App\Services\AgendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking/{booking}/update', name: 'admin_booking_update', methods: ['POST'])]
class UpdateController extends AbstractController
{
    private BookingManager $bookingManager;

    private AgendaService $agendaService;

    public function __construct(BookingManager $bookingManager, AgendaService $agendaService)
    {
        $this->bookingManager = $bookingManager;
        $this->agendaService = $agendaService;
    }

    public function __invoke(Request $request, Booking $booking): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Booking $booking */
            $booking = $form->getData();
            $pet = $booking->getPet();

            if ($pet !== null) {
                $booking->setCustomer($pet->getCustomer());
            }

            $bookingDate = $booking->getDate();

            if ($bookingDate !== null) {
                $daySlots = $this->agendaService->getDaySlots($bookingDate);
                $bookingHour = $bookingDate->format('H:i');

                if (!\array_key_exists($bookingHour, $daySlots)) {
                    $nearestTimeSlot = $this->agendaService->findNearestTimeSlot($daySlots, $bookingHour);
                    [$hour, $minute] = explode(':', $nearestTimeSlot);
                    $bookingDate->setTime((int)$hour, (int)$minute);
                    $booking->setDate($bookingDate);
                }
            }

            try {
                $this->bookingManager->save($booking);
            } catch (\Throwable $exception) {
                $this->addFlash('error','Se ha producido un error, la cita no se ha actualizado');
            }

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
