<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Services;

use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\ListInsuredBookingsInterface;

class ListInsuredBookingsService implements ListInsuredBookingsInterface
{
    public function __construct(
        private readonly BookingsRepositoryInterface $bookingsRepository
    ) {
    }

    public function __invoke(): array
    {
        return $this->bookingsRepository->getInsured();
    }
}
