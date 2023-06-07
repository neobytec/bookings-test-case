<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface ValidateBookingInterface
{
    public function __invoke(string $reference): bool;
}
