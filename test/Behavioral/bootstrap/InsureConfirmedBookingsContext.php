<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use Behat\Behat\Tester\Exception\PendingException;
use Imbo\BehatApiExtension\Context\ApiContext;

class InsureConfirmedBookingsContext extends ApiContext
{
    /**
     * @Given A booking
     */
    public function aBooking(): void
    {
        throw new PendingException();
    }

    /**
     * @When A confirmation arrives
     */
    public function aConfirmationArrives(): void
    {
        throw new PendingException();
    }

    /**
     * @Then Insure the booking
     */
    public function insureTheBooking(): void
    {
        throw new PendingException();
    }
}
