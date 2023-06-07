<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Services;

use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\CancelBookingsInterface;

class CancelBookingsService implements CancelBookingsInterface
{
    public function __construct(
        private readonly BookingsRepositoryInterface $bookingsRepository
    ) {
    }

    public function __invoke(BookingDTOInterface $booking): bool
    {
        return $this->bookingsRepository->cancel($booking);
    }
}
