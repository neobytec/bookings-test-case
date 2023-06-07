<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

use DateTime;

interface BookingDTOInterface
{
    public function getReference(): string;

    public function getCheckIn(): DateTime;

    public function getCheckOut(): DateTime;

    public function getPeople(): int;

    public function getPremiumAmount(): float;

    public function isInsured(): bool;

    public function isCancelled(): bool;
}
