<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Models;

use App\Domain\Bookings\Ports\BookingDTOInterface;
use DateTime;

class Booking implements BookingDTOInterface
{
    public function __construct(
        private readonly string $reference,
        private readonly DateTime $checkIn,
        private readonly DateTime $checkOut,
        private readonly int $people,
        private readonly BookingStatusEnum $status,
        private readonly float $premiumAmount = 0,
    ) {
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getCheckIn(): DateTime
    {
        return $this->checkIn;
    }

    public function getCheckOut(): DateTime
    {
        return $this->checkOut;
    }

    public function getPeople(): int
    {
        return $this->people;
    }

    public function getPremiumAmount(): float
    {
        return $this->premiumAmount;
    }

    public function isInsured(): bool
    {
        return $this->status->value === BookingStatusEnum::Insured->value;
    }

    public function isCancelled(): bool
    {
        return $this->status->value === BookingStatusEnum::Cancelled->value;
    }
}
