<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface GetBookingInterface
{
    public function __invoke(string $reference): ?BookingDTOInterface;
}
