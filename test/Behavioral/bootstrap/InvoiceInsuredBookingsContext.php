<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\ListInsuredBookingsInterface;
use App\Domain\Bookings\Services\ListInsuredBookingsService;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use PHPUnit\Framework\TestCase;

use function count;

class InvoiceInsuredBookingsContext extends TestCase implements Context
{
    private const DATETIME_FORMAT = 'Y-m-d';

    private BookingsRepositoryInterface $bookingsRepository;

    private array $bookings;

    private array $insuredBookings;

    private ListInsuredBookingsInterface $listInsuredBookings;

    /** @BeforeScenario  */
    public function before(): void
    {
        $this->bookingsRepository = $this->createMock(BookingsRepositoryInterface::class);
        $this->bookingsRepository->method('save')->willReturnCallback(function (BookingDTOInterface $booking) {
            $this->bookings[$booking->getReference()] = $booking;
            return true;
        });
        $this->bookingsRepository->method('get')->willReturnCallback(function (string $reference) {
            return $this->bookings[$reference] ?? null;
        });
        $this->bookingsRepository->method('getInsured')->willReturnCallback(function () {
            $result = [];
            /** @var BookingDTOInterface $booking */
            foreach ($this->bookings as $booking) {
                if ($booking->isInsured()) {
                    $result[] = $booking;
                }
            }

            return $result;
        });

        $this->listInsuredBookings = new ListInsuredBookingsService($this->bookingsRepository);
    }

    /**
     * @Given An insured booking
     */
    public function anInsuredBooking(TableNode $table): void
    {
        /** @var array<array-key,string> $row */
        foreach ($table as $row) {
            $status = match ($row['status']) {
                BookingStatusEnum::Insured->name => BookingStatusEnum::Insured,
                BookingStatusEnum::Cancelled->name => BookingStatusEnum::Cancelled,
                default => BookingStatusEnum::NotInsured
            };

            /** @var DateTime $checkIn */
            $checkIn = DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkIn']);
            /** @var DateTime $checkOut */
            $checkOut = DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkOut']);

            $booking = new Booking(
                $row['reference'],
                $checkIn,
                $checkOut,
                (int) $row['people'],
                $status
            );

            $this->bookingsRepository->save($booking);
        }
    }

    /**
     * @When Someone ask for them
     */
    public function someoneAskForThem(): void
    {
        $this->insuredBookings = $this->listInsuredBookings->__invoke();
    }

    /**
     * @Then List all insured bookings with its premium amount
     */
    public function listAllInsuredBookingsWithItsPremiumAmount(): void
    {
        self::assertEquals(3, count($this->insuredBookings));
    }
}
