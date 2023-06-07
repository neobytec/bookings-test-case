<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\TestCase;

class ReinsureBookingsContext extends TestCase implements Context
{
    /**
     * @Given An insured booking
     */
    public function anInsuredBooking(): void
    {
        throw new PendingException();
    }

    /**
     * @When A modification arrives
     */
    public function aModificationArrives(): void
    {
        throw new PendingException();
    }

    /**
     * @Then Reinsure the booking with the newer information
     */
    public function reinsureTheBookingWithTheNewerInformation(): void
    {
        throw new PendingException();
    }
}
