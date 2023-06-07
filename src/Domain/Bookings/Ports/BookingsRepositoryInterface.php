<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface BookingsRepositoryInterface
{
    public function get(string $reference): ?BookingDTOInterface;
}
