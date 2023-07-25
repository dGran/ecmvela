<?php

declare(strict_types=1);

namespace App\Services;

class AgendaService
{
    public const AVAILABLE_DAYS = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
    ];

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

    // TODO remove const and get data from PublicHoliday entity
    private const PUBLIC_HOLIDAYS = [
        2023 => [
            8 => [14, 15, 16, 17, 18,],
            9 => [8,],
            10 => [9, 12,],
            11 => [1,],
            12 => [6, 8, 25,],
        ],
        2024 => [
            1 => [1, 6,],
            3 => [19,],
            8 => [15,],
            9 => [8,],
            10 => [6, 8,],
        ]
    ];

    public const HOUR_START = '09:30';
    public const HOUR_END = '19:00';
    public const DEFAULT_ESTIMATED_DURATION = 30;

    public function generateDaySlots(\DateTime $day): array
    {
        $slots = [];
        $numberDayOfTheWeek = $day->format('N');

        if (!\array_key_exists($numberDayOfTheWeek, self::AVAILABLE_DAYS)) {
            return $slots;
        }

        $startDate = \DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d') . ' ' . self::HOUR_START);
        $endDate = \DateTime::createFromFormat('Y-m-d H:i', date('Y-m-d') . ' ' . self::HOUR_END);

        while ($startDate <= $endDate) {
            $slots[] = $startDate->format('Y-m-d H:i:s');

            $startDate->modify('+'.self::DEFAULT_ESTIMATED_DURATION.' minutes');
        }


        return $slots;
    }

    public function getCalendarMonthData($month, $year): array
    {
        $month = (int) $month;
        $year = (int) $year;

        $firstDay = new \DateTime("$year-$month-01");
        $numberOfDays = $firstDay->format('t');
        $monthName = $firstDay->format('F');

        $publicHolidays = $this->getPublicHolidaysByMonthAndYear($month, $year);

        return [
            'year' => $year,
            'month' => $month,
            'month_name' => $monthName,
            'number_of_days' => $numberOfDays,
            'public_holidays' => $publicHolidays,
            'business_days' => $numberOfDays - \count($publicHolidays),
        ];
    }

    private function getPublicHolidaysByMonthAndYear(int $month, int $year): array
    {
        $weekendDaysOfMonth = $this->getWeekendDaysOfMonth($month, $year);

        if (isset(self::PUBLIC_HOLIDAYS[$year][$month])) {
            $yearPublicHolidays = self::PUBLIC_HOLIDAYS[$year][$month];

            return array_unique(array_merge($yearPublicHolidays, $weekendDaysOfMonth));
        }

        return $weekendDaysOfMonth;
    }

    private function getWeekendDaysOfMonth(int $month, int $year): array
    {
        $weekendDays = [];
        $firstDayOfMonth = new \DateTime("$year-$month-01");
        $lastDayOfMonth = (new \DateTime("$year-$month-01"))->modify('last day of this month');

        while ($firstDayOfMonth <= $lastDayOfMonth) {
            if ($firstDayOfMonth->format('N') >= 6) {
                $weekendDays[] = (int) $firstDayOfMonth->format('j');
            }
            $firstDayOfMonth->modify('+1 day');
        }

        return $weekendDays;
    }
}