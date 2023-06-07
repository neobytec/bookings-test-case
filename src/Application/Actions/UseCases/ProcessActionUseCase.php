<?php

declare(strict_types=1);

namespace App\Application\Actions\UseCases;

use App\Domain\Actions\Models\ActionEnum;
use App\Domain\Actions\Ports\ActionDTOInterface;
use App\Domain\Actions\Ports\ValidateActionInterface;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\CancelBookingsInterface;
use App\Domain\Bookings\Ports\GetBookingInterface;
use App\Domain\Exceptions\ErrorException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Insurances\Ports\CreateInsuranceInterface;

class ProcessActionUseCase
{
    public function __construct(
        private readonly GetBookingInterface $getBooking,
        private readonly ValidateActionInterface $validateAction,
        private readonly CreateInsuranceInterface $createInsurance,
        private readonly CancelBookingsInterface $cancelBookings
    ) {
    }

    public function __invoke(ActionDTOInterface $action): void
    {
        $booking = $this->getBooking->__invoke($action->getReference());

        if ($booking === null) {
            throw ValidationException::create('The booking does not exists');
        }

        if ($this->validateAction->__invoke($action)) {
            throw ErrorException::create('The action cannot be processed');
        }

        if ($action->getAction() === ActionEnum::Cancellation) {
            $this->cancelBookings->__invoke($booking);
            return;
        }

        if ($action->getAction() === ActionEnum::Modification) {
            $booking = new Booking(
                $action->getReference(),
                $action->getCheckIn(),
                $action->getCheckOut(),
                $action->getPeople(),
                BookingStatusEnum::Insured
            );
        }

        if ($this->createInsurance->__invoke($booking)) {
            throw ErrorException::create('The insurance cannot be created');
        }
    }
}
