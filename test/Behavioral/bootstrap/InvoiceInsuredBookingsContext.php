<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\TestCase;

class InvoiceInsuredBookingsContext extends TestCase implements Context
{
    /**
     * @Given An insured booking
     */
    public function anInsuredBooking(): void
    {
        throw new PendingException();
    }

    /**
     * @When Someone ask for them
     */
    public function someoneAskForThem(): void
    {
        throw new PendingException();
    }

    /**
     * @Then List all insured bookings with its premium amount
     */
    public function listAllInsuredBookingsWithItsPremiumAmount(): void
    {
        throw new PendingException();
    }
}
