<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Infrastructure\Data\Entity\Bookings;
use App\Infrastructure\Data\Repository\BookingsRepository;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use Doctrine\ORM\EntityManager;
use Imbo\BehatApiExtension\Context\ApiContext;

use function PHPUnit\Framework\assertCount;

class GenerateReportCancelledInsuredBookingsAPIContext extends ApiContext
{
    private const DATETIME_FORMAT = 'Y-m-d';

    private BookingsRepositoryInterface $bookingsRepository;

    private array $createdBookings = [];

    /** @BeforeScenario  */
    public function before(): void
    {
        $container = require __DIR__ . '/../../../config/container.php';
        /** @var EntityManager $entityManager */
        $entityManager            = $container->get(EntityManager::class);
        $this->bookingsRepository = new BookingsRepository(
            $entityManager,
            $entityManager->getClassMetadata(Bookings::class)
        );
    }

    /**
     * @Given The followings bookings
     */
    public function theFollowingsBookings(TableNode $table): void
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
            $this->createdBookings[] = $booking->getReference();
        }
    }

    /**
     * @Then The number of cancelled bookings is :number
     */
    public function theNumberOfCancelledBookingsIs(string $number): void
    {
        /** @var array $body */
        $body = $this->getResponseBody();
        assertCount((int) $number, $body);
    }

    /**
     * @Then I delete the bookings created
     */
    public function iDeleteTheBookingsCreated(): void
    {
        /** @var string $reference */
        foreach ($this->createdBookings as $reference) {
            $this->bookingsRepository->remove($reference);
        }
    }
}
