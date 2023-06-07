<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface CancelBookingsInterface
{
    public function __invoke(BookingDTOInterface $booking): bool;
}
