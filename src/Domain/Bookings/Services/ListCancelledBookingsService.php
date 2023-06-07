<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Services;

use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\ListCancelledBookingsInterface;

class ListCancelledBookingsService implements ListCancelledBookingsInterface
{
    public function __construct(
        private readonly BookingsRepositoryInterface $bookingsRepository
    ) {
    }

    public function __invoke(): array
    {
        return $this->bookingsRepository->getCancelled();
    }
}
