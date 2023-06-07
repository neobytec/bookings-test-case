<?php

declare(strict_types=1);

namespace App\Application\Bookings\UseCases;

use App\Domain\Bookings\Ports\ListInsuredBookingsInterface;

class ListInsuredBookingsUseCase
{
    public function __construct(
        private readonly ListInsuredBookingsInterface $listInsuredBookings
    ) {
    }

    public function __invoke(): array
    {
        return $this->listInsuredBookings->__invoke();
    }
}
