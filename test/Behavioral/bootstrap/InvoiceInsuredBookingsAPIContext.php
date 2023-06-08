<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Infrastructure\Data\Entity\Bookings;
use App\Infrastructure\Data\Repository\BookingsRepository;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Utils;
use Imbo\BehatApiExtension\Context\ApiContext;

use function json_decode;
use function PHPUnit\Framework\assertCount;

use const JSON_THROW_ON_ERROR;

class InvoiceInsuredBookingsAPIContext extends ApiContext
{
    private const DATETIME_FORMAT = 'Y-m-d';

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
        $this->request = $this->request->withBody(Utils::streamFor($payload));
    }

    /**
     * @Then The number of insured bookings is :number
     */
    public function theNumberOfInsuredBookingsIs(string $number): void
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
            $this->getBookingsRepository()->remove($reference);
        }
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
