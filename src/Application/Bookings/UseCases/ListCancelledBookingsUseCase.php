<?php

declare(strict_types=1);

namespace App\Application\Bookings\UseCases;

use App\Domain\Bookings\Ports\ListCancelledBookingsInterface;

class ListCancelledBookingsUseCase
{
    public function __construct(
        private readonly ListCancelledBookingsInterface $listCancelledBookings
    ) {
    }

    public function __invoke(): array
    {
        return $this->listCancelledBookings->__invoke();
    }
}
