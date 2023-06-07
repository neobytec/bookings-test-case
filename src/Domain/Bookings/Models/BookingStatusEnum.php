<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Models;

enum BookingStatusEnum: int
{
    case NotInsured = 1;
    case Insured    = 2;
    case Cancelled  = 3;
}
