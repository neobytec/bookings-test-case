<?php

declare(strict_types=1);

namespace App\Domain\Insurances\Services;

use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Insurances\Models\Insurance;
use App\Domain\Insurances\Ports\CreateInsuranceInterface;
use App\Domain\Insurances\Ports\InsurancesRepositoryInterface;

class CreateInsuranceService implements CreateInsuranceInterface
{
    private const PRICE_PER_PERSON = 0.12;
    private const PRICE_PER_DAY    = 0.08;

    public function __construct(
        private readonly InsurancesRepositoryInterface $insurancesRepository,
        private readonly BookingsRepositoryInterface $bookingsRepository
    ) {
    }

    public function __invoke(BookingDTOInterface $booking): bool
    {
        $this->bookingsRepository->save($booking);

        $days          = $booking->getCheckOut()->diff($booking->getCheckIn())->days;
        $premiumAmount = ($days * self::PRICE_PER_DAY) + ($booking->getPeople() * self::PRICE_PER_PERSON);

        //@TODO call to insurance API

        $insurance = new Insurance($premiumAmount, reference: $booking->getReference());
        return $this->insurancesRepository->save($insurance);
    }
}
