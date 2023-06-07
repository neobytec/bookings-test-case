<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface ListInsuredBookingsInterface
{
    public function __invoke(): array;
}
