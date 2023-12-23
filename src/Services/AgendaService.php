<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Booking;
use App\Manager\BookingManager;
use App\Manager\PublicHolidayManager;
use App\Model\Agenda\SlotBooking;

class AgendaService
{
    public const DAYS_OF_THE_WEEK = [
        1 => [
            'name' => 'Monday',
            'short_name' => 'Lu',
        ],
        2 => [
            'name' => 'Tuesday',
            'short_name' => 'Ma',
        ],
        3 => [
            'name' => 'Wednesday',
            'short_name' => 'We',
        ],
        4 => [
            'name' => 'Thursday',
            'short_name' => 'Th',
        ],
        5 => [
            'name' => 'Friday',
            'short_name' => 'Fr',
        ],
        6 => [
            'name' => 'Saturday',
            'short_name' => 'Sa',
        ],
        7 => [
            'name' => 'Sunday',
            'short_name' => 'Su',
        ],
    ];

    private const AVAILABLE_DAYS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
    ];

    private const WORKING_HOURS_START_TIME = '09:30';

    private const WORKING_HOURS_END_TIME = '19:00';

    private const ADITIONAL_START_TIME = '08:00';

    private const ADITIONAL_END_TIME = '22:00';

    private const SLOT_INTERVAL = 15;

    private const MAX_TIME_FOR_ESTIMATION  = 480;

    private PublicHolidayManager $publicHolidayManager;

    private BookingManager $bookingManager;

    public function __construct(PublicHolidayManager $publicHolidayManager, BookingManager $bookingManager) {
        $this->publicHolidayManager = $publicHolidayManager;
        $this->bookingManager = $bookingManager;
    }

    //TODO: CREAR SLOTS EN FUNCION DE HORARIOS OFICIALES POR DIA, POR EJEMPLO, LOS VIERNES SE VA A CERRAR ANTES
    //TODO: ALMACENAR TAMBIEN PARA QUE PUEDA SER CONFIGURABLE LOS WORKING HOURS START Y END Y LOS ADITIONAL, y así no tener que usar las constantes
    //TODO: CREAR TABLA CON HORARIOS PARA QUE PUEDAN SER EDITABLES

    public function getDayBookings(\DateTime $day): void
    {
        $dateTo = clone $day;
        $dateTo->modify('+1 day');
        $dayBookings = $this->bookingManager->findByDateFromAndDateTo($day, $dateTo);
    }

    /**
     * @param Booking[] $bookings
     *
     * @return array<string, Booking[]>
     */
    public function  generateDaySlots(\DateTime $day, array $bookings): array
    {
        $slots = [];
        $numberDayOfTheWeek = $day->format('N');

//        if (!\array_key_exists($numberDayOfTheWeek, self::AVAILABLE_DAYS)) {
//            return $slots;
//        }

        $monthPublicHolidays = $this->getPublicHolidays((int)$day->format('m'), (int)$day->format('Y'));
        $isPublicHoliday = false;

        if (\array_key_exists((int)$day->format('d'), $monthPublicHolidays)) {
            $isPublicHoliday = true;
        }

        [$startHour, $startMinute] = \explode(':', self::ADITIONAL_START_TIME);
        [$endHour, $endMinute] = \explode(':', self::ADITIONAL_END_TIME);
        [$workingHoursStartHour, $workingHoursStartMinute] = \explode(':', self::WORKING_HOURS_START_TIME);
        [$workingHoursEndHour, $workingHoursEndMinute] = \explode(':', self::WORKING_HOURS_END_TIME);
        $startDate = (clone $day)->setTime((int)$startHour, (int)$startMinute);
        $endDate = (clone $day)->setTime((int)$endHour, (int)$endMinute);
        $workingHoursStartDate = (clone $day)->setTime((int)$workingHoursStartHour, (int)$workingHoursStartMinute);
        $workingHoursEndDate = (clone $day)->setTime((int)$workingHoursEndHour, (int)$workingHoursEndMinute);

        $currentSlotDate = clone $startDate;

        while ($currentSlotDate <= $endDate) {
            $currentSlotFinishDate = (clone $currentSlotDate)->modify('+'.self::SLOT_INTERVAL.' minutes');
            $currentSlotFinishDate = \min($currentSlotFinishDate, $endDate);
            $slotBookings = [];

            foreach ($bookings as $bookingKey => $booking) {
                $bookingDate = $booking->getDate();

                if ($bookingDate === null) {
                    continue;
                }

                $estimatedDuration = $booking->getEstimatedDuration() ?? self::SLOT_INTERVAL;

                $bookingStart = clone $bookingDate;
                $bookingEnd = clone $bookingDate;
                $bookingEnd->modify('+'.$estimatedDuration.' minutes');

                if (
                    $bookingStart <= $currentSlotDate && $bookingEnd >= $currentSlotFinishDate
                ) {
                    $slotBooking = new SlotBooking();
                    $slotBooking->booking = $booking;

                    try {
                        $slotBooking->color = SlotBooking::COLORS[$bookingKey];
                    } catch(\Throwable $exception) {
                        $slotBooking->color = SlotBooking::DEFAULT_COLOR;
                    }

                    $slotBookings[] = $slotBooking;
                }
            }

            $isWorkingHours = $currentSlotDate >= $workingHoursStartDate && $currentSlotDate < $workingHoursEndDate;

            $slots[$currentSlotDate->format('Y-m-d H:i:s')] = [
                'slotBooking' => $slotBookings,
                'isWorkingHours' => $isWorkingHours && !$isPublicHoliday,
            ];

            $currentSlotDate->modify('+'.self::SLOT_INTERVAL.' minutes');
        }

        return $slots;
    }

    /**
     * @return array{year: int, month: int, mont_name: string, number_of_days: int, public_holidays: array, business_days: int, days: array}
     */
    public function getCalendarMonthData(int $month, int $year): array
    {
        $firstDay = new \DateTime("$year-$month-01");
        $numberOfDays = $firstDay->format('t');
        $monthName = $firstDay->format('F');
        $publicHolidaysOfMonth = $this->getPublicHolidays($month, $year);

        $dayCounter = 1;
        $currentDay = $firstDay;
        $days = [];

        do {
            $dateFrom = (clone $currentDay)->setTime(0, 0);
            $dateTo = (clone $currentDay)->setTime(23, 59, 59);
            $dayBookings = $this->bookingManager->findByDateFromAndDateTo($dateFrom, $dateTo);
            $slots = $this->generateDaySlots($dateFrom, $dayBookings);
            $isPublicHoliday = false;
            $publicHoliday = null;

            if (\array_key_exists($dayCounter, $publicHolidaysOfMonth)) {
                $isPublicHoliday = true;
                $publicHoliday = $publicHolidaysOfMonth[$dayCounter];
            }

            $isCompleteDay = $this->isCompleteDay($slots, $isPublicHoliday);

            $numBookings = 0;
            $numWorkingHourSlots = 0;

            foreach ($slots as $slot) {
                if (!empty($slot['slotBooking'])) {
                    $numBookings++;
                }

                if ($slot['isWorkingHours']) {
                    $numWorkingHourSlots++;
                }
            }

            $days[$dayCounter] = [
                'slots' => $slots,
                'num_bookings' => $numBookings,
                'num_working_hour_slots' => $numWorkingHourSlots,
                'is_complete_day' => $isCompleteDay,
                'public_holiday' => $publicHoliday,
            ];

            $currentDay->modify('+1 day');
            $dayCounter++;
        } while ($dayCounter <= $numberOfDays);

        return [
            'year' => $year,
            'month' => $month,
            'month_name' => $monthName,
            'number_of_days' => $numberOfDays,
            'public_holidays' => $publicHolidaysOfMonth,
            'business_days' => $numberOfDays - \count($publicHolidaysOfMonth),
            'days' => $days,
        ];
    }

    public function getDaySlots(\DateTime $day): array
    {
        $slots = [];

        [$startHour, $startMinute] = \explode(':', self::ADITIONAL_START_TIME);
        [$endHour, $endMinute] = \explode(':', self::ADITIONAL_END_TIME);
        $startDate = (clone $day)->setTime((int)$startHour, (int)$startMinute);
        $endDate = (clone $day)->setTime((int)$endHour, (int)$endMinute);

        $currentSlotDate = $startDate;

        while ($currentSlotDate <= $endDate) {
            $slotDate = clone $currentSlotDate;
            $slots[$slotDate->format('H:i')] = $slotDate;
            $currentSlotDate->modify('+'.self::SLOT_INTERVAL.' minutes');
        }

        return $slots;
    }

    public function findNearestTimeSlot(array $timeSlots, $targetTime): string
    {
        $targetTimestamp = \strtotime($targetTime);
        $nearestTimeSlot = null;
        $minDifference = PHP_INT_MAX;

        foreach ($timeSlots as $timeSlotKey => $timeSlotValue) {
            $timeSlotTimestamp = \strtotime($timeSlotKey);
            $difference = \abs($timeSlotTimestamp - $targetTimestamp);

            if ($difference < $minDifference) {
                $minDifference = $difference;
                $nearestTimeSlot = $timeSlotKey;
            }
        }

        return $nearestTimeSlot;
    }

    /**
     * @param array<string, Booking[]> $slots
     */
    public function isCompleteDay(array $slots, bool $isPublicHoliday): bool
    {
        if ($isPublicHoliday) {
            return false;
        }

        foreach ($slots as $slot) {
            if ($slot['isWorkingHours'] && empty($slot['slotBooking'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @throws \Exception
     */
    public function getExtraHoursOfDay(array $slots): string
    {
        $totalMinutes = 0;

        foreach ($slots as $slot) {
            if (!$slot['isWorkingHours'] && !empty($slot['slotBooking'])) {
                $totalMinutes += self::SLOT_INTERVAL;
            }
        }

        if ($totalMinutes === 0) {
            return '-';
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $formattedTime = '';

        if ($hours > 0) {
            $formattedTime .= $hours . 'h';

            if ($minutes > 0) {
                $formattedTime .= ' y ';
            }
        }

        if ($minutes > 0) {
            $formattedTime .= $minutes . 'm';
        }

        return $formattedTime;
    }

    /**
     * @return array<string, int>
     */
    public function getBookingEstimatedDurations(): array
    {
        $bookingEstimatedDurations = [];

        for ($i = self::SLOT_INTERVAL; $i <= self::MAX_TIME_FOR_ESTIMATION; $i += self::SLOT_INTERVAL) {
            $label = $this->formatDurationLabel($i);
            $bookingEstimatedDurations[$label] = $i;
        }

        return $bookingEstimatedDurations;
    }

    private function formatDurationLabel(int $interval): string
    {
        if ($interval < 60) {
            return $interval . ' minutos';
        }

        $hours = \floor($interval / 60);
        $minutes = $interval % 60;

        $label = $hours.' hora'.($hours > 1 ? 's' : '');

        if ($minutes > 0) {
            $label .= ' y '.$minutes.' minutos';
        }

        return $label;
    }

    /**
     * @return array<int, string>
     */
    private function getPublicHolidays(int $month, int $year): array
    {
        $weekendDaysOfMonth = $this->getWeekendDaysOfMonth($month, $year);
        $publicHolidays = $this->publicHolidayManager->findByMonthAndYear($month, $year);

        $publicHolidaysAndWeekendDays = [];

        foreach ($publicHolidays as $publicHoliday) {
            $publicHolidaysAndWeekendDays[(int)$publicHoliday->getDate()->format('d')] = $publicHoliday->getName();
        }

        foreach ($weekendDaysOfMonth as $weekendDayOfMonth) {
            if (!\array_key_exists($weekendDayOfMonth, $publicHolidaysAndWeekendDays)) {
                $publicHolidaysAndWeekendDays[$weekendDayOfMonth] = 'Fin de semana';
            }
        }

        return $publicHolidaysAndWeekendDays;
    }

    /**
     * @return array<int, int>
     */
    private function getWeekendDaysOfMonth(int $month, int $year): array
    {
        $weekendDays = [];
        $firstDayOfMonth = new \DateTime("$year-$month-01");
        $lastDayOfMonth = (new \DateTime("$year-$month-01"))->modify('last day of this month');

        while ($firstDayOfMonth <= $lastDayOfMonth) {
            if ($firstDayOfMonth->format('N') >= 6) {
                $weekendDays[] = (int)$firstDayOfMonth->format('j');
            }
            $firstDayOfMonth->modify('+1 day');
        }

        return $weekendDays;
    }
}
