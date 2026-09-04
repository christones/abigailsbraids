<?php

namespace App\Support;

class BookingSlots
{
    /**
     * The bookable time slots offered by the salon.
     *
     * @return list<string>
     */
    public static function all(): array
    {
        return ['09:00', '10:30', '13:00', '14:30', '16:00', '17:30'];
    }
}
