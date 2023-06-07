<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Services;

use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\ValidateBookingInterface;

class ValidateBookingService implements ValidateBookingInterface
{
    public function __construct(
        private readonly BookingsRepositoryInterface $bookingsRepository
    ) {
    }

    public function __invoke(string $reference): bool
    {
        $booking = $this->bookingsRepository->get($reference);
        return ! $booking;
    }
}
