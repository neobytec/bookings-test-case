<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use PHPUnit\Framework\TestCase;

class GenerateReportCancelledInsuredBookingsContext extends TestCase implements Context
{
    /**
     * @Given Some cancelled insured bookings
     */
    public function someCancelledInsuredBookings(): void
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
     * @Then List them all
     */
    public function listThemAll(): void
    {
        throw new PendingException();
    }
}
