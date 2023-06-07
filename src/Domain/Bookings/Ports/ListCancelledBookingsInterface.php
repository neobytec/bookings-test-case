<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface ListCancelledBookingsInterface
{
    public function __invoke(): array;
}
