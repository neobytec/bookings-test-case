<?php

declare(strict_types=1);

namespace App\Domain\Insurances\Ports;

use App\Domain\Bookings\Ports\BookingDTOInterface;

interface CreateInsuranceInterface
{
    public function __invoke(BookingDTOInterface $booking): bool;
}
