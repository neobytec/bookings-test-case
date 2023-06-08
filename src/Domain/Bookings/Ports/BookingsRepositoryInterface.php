<?php

declare(strict_types=1);

namespace App\Domain\Bookings\Ports;

interface BookingsRepositoryInterface
{
    public function get(string $reference): ?BookingDTOInterface;

    public function save(BookingDTOInterface $booking): bool;

    public function cancel(BookingDTOInterface $booking): bool;

    public function getInsured(): array;

    public function getCancelled(): array;

    public function remove(string $reference): bool;
}
