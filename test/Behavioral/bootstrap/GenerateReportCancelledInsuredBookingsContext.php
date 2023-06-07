<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Ports\ListCancelledBookingsInterface;
use App\Domain\Bookings\Services\ListCancelledBookingsService;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use PHPUnit\Framework\TestCase;

use function count;

class GenerateReportCancelledInsuredBookingsContext extends TestCase implements Context
{
    private const DATETIME_FORMAT = 'Y-m-d';

    private BookingsRepositoryInterface $bookingsRepository;

    private array $bookings;

    private array $cancelledBookings;

    private ListCancelledBookingsInterface $listCancelledBookings;

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
        $this->bookingsRepository->method('getCancelled')->willReturnCallback(function () {
            $result = [];
            /** @var BookingDTOInterface $booking */
            foreach ($this->bookings as $booking) {
                if ($booking->isCancelled()) {
                    $result[] = $booking;
                }
            }

            return $result;
        });

        $this->listCancelledBookings = new ListCancelledBookingsService($this->bookingsRepository);
    }

    /**
     * @Given Some cancelled insured bookings
     */
    public function someCancelledInsuredBookings(TableNode $table): void
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
        $this->cancelledBookings = $this->listCancelledBookings->__invoke();
    }

    /**
     * @Then List them all
     */
    public function listThemAll(): void
    {
        self::assertEquals(2, count($this->cancelledBookings));
    }
}
