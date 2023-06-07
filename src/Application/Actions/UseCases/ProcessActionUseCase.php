<?php

declare(strict_types=1);

namespace App\Application\Actions\UseCases;

use App\Domain\Actions\Ports\ActionDTOInterface;
use App\Domain\Actions\Ports\ProcessActionInterface;
use App\Domain\Bookings\Ports\GetBookingInterface;
use App\Domain\Exceptions\ErrorException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Insurances\Ports\CreateInsuranceInterface;

class ProcessActionUseCase
{
    public function __construct(
        private readonly GetBookingInterface      $getBooking,
        private readonly ProcessActionInterface   $processAction,
        private readonly CreateInsuranceInterface $createInsurance
    ) {
    }

    public function __invoke(ActionDTOInterface $action): void
    {
        $booking = $this->getBooking->__invoke($action->getReference());

        if ($booking === null) {
            throw ValidationException::create('The booking does not exists');
        }

        if ($this->processAction->__invoke($action)) {
            throw ErrorException::create('The action cannot be processed');
        }

        if ($this->createInsurance->__invoke($booking)) {
            throw ErrorException::create('The insurance cannot be created');
        }
    }
}
