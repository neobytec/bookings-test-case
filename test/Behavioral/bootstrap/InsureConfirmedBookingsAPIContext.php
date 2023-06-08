<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Infrastructure\Data\Entity\Bookings;
use App\Infrastructure\Data\Repository\BookingsRepository;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Utils;
use Imbo\BehatApiExtension\Context\ApiContext;

use function json_decode;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

use const JSON_THROW_ON_ERROR;

class InsureConfirmedBookingsAPIContext extends ApiContext
{
    private const DATETIME_FORMAT = 'Y-m-d';

    private const NULL                     = 'null';
    private const BOOKING_STATUS_INSURED   = 'Insured';
    private const BOOKING_STATUS_CANCELLED = 'Cancelled';

    private array $payload;

    private array $createdBookings = [];

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

            $this->getBookingsRepository()->save($booking);
            $this->createdBookings[] = $booking->getReference();
        }
    }

    /**
     * @Given The request body is :payload
     */
    public function theRequestBodyIs(string $payload): void
    {
        /** @var array<array-key,mixed> $payloadData */
        $payloadData   = json_decode($payload, true, 512, JSON_THROW_ON_ERROR);
        $this->payload = $payloadData;
        $this->request = $this->request->withBody(Utils::streamFor($payload));
    }

    /**
     * @Then The status of the booking is :status
     */
    public function theStatusOfTheBookingIs(string $status): void
    {
        $booking = $this->getBooking($status);
        if (! $booking) {
            return;
        }

        $result = match ($status) {
            self::BOOKING_STATUS_INSURED => $booking->isInsured(),
            self::BOOKING_STATUS_CANCELLED => $booking->isCancelled(),
            default => false
        };

        assertTrue($result);
    }

    /**
     * @Then The premiumAmount is :premiumAmount
     */
    public function thePremiumAmountIs(string $premiumAmount): void
    {
        $booking = $this->getBooking($premiumAmount);
        if (! $booking) {
            return;
        }

        assertEquals($premiumAmount, $booking->getPremiumAmount());
    }

    /**
     * @Then I delete the bookings created
     */
    public function iDeleteTheBookingsCreated(): void
    {
        /** @var string $reference */
        foreach ($this->createdBookings as $reference) {
            $this->getBookingsRepository()->remove($reference);
        }
    }

    private function getBooking(string $status): ?BookingDTOInterface
    {
        if (($status === self::NULL) || ! isset($this->payload['reference'])) {
            return null;
        }

        $booking = $this->getBookingsRepository()->findOneBy(['reference' => $this->payload['reference']]);
        assertNotNull($booking);

        return $booking;
    }

    private function getBookingsRepository(): BookingsRepository
    {
        $container = require __DIR__ . '/../../../config/container.php';
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return new BookingsRepository(
            $entityManager,
            $entityManager->getClassMetadata(Bookings::class)
        );
    }
}
