<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Services;

use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\GetBookingInterface;

class GetBookingService implements GetBookingInterface
{
    public function __construct(
        private readonly BookingsRepositoryInterface $bookingsRepository
    ) {
    }

    public function __invoke(string $reference): ?BookingDTOInterface
    {
        return $this->bookingsRepository->get($reference);
    }
}
