<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Manager\BookingManager;
use App\Services\AgendaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    private AgendaService $agendaService;

    private BookingManager $bookingManager;

    public function __construct(AgendaService $agendaService, BookingManager $bookingManager)
    {
        $this->agendaService = $agendaService;
        $this->bookingManager = $bookingManager;
    }

    #[Route('/admin/agenda/{day?}', name: 'admin_agenda', methods: 'GET')]
    public function index(Request $request, \DateTime $day = null): Response
    {
        if ($day === null) {
            $day = new \DateTime();
        }

        $dateTo = clone $day;
        $dateTo->modify('+1 day');
        $dayBookings = $this->bookingManager->findByDateFromAndDateTo($day, $dateTo);
        $slots = $this->agendaService->generateDaySlots($day, $dayBookings);

        $month = $day->format('m');
        $year = $day->format('Y');

        $calendarMonthData = $this->agendaService->getCalendarMonthData($month, $year);
        $daysOfTheWeek = AgendaService::DAYS_OF_THE_WEEK;
        $dayOfTheMonth = $day->format('d');

        return $this->render('admin/agenda/index.html.twig', [
            'day' => $day,
            'slots' => $slots,
            'calendar_month_data' => $calendarMonthData,
            'days_of_the_week' => $daysOfTheWeek,
            'day_of_the_month' => $dayOfTheMonth,
            'bookings' => $dayBookings,
        ]);
    }
}