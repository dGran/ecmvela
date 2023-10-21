<?php

declare(strict_types=1);

namespace App\Model\Agenda;

use App\Entity\Booking;

class SlotBooking
{
    public const DEFAULT_COLOR = 'slate';

    public const COLORS = [
        'red',
        'lime',
        'teal',
        'indigo',
        'orange',
        'green',
        'cyan',
        'violet',
        'amber',
        'emerald',
        'sky',
        'purple',
        'yellow',
        'blue',
        'fuchsia',
        'pink',
        'rose',
    ];

    public Booking $booking;

    public string $color = self::DEFAULT_COLOR;
}
