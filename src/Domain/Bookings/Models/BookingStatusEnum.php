<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Models;

enum BookingStatusEnum: int
{
    case Insured   = 1;
    case Cancelled = 2;
}
