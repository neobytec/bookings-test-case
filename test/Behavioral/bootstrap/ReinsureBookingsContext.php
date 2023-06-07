<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Application\Actions\UseCases\ProcessActionUseCase;
use App\Domain\Actions\Models\ActionEnum;
use App\Domain\Actions\Ports\ActionsRepositoryInterface;
use App\Domain\Actions\Services\ValidateActionService;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Services\CancelBookingsService;
use App\Domain\Bookings\Services\GetBookingService;
use App\Domain\Exceptions\ErrorException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Insurances\Ports\InsurancesRepositoryInterface;
use App\Domain\Insurances\Services\CreateInsuranceService;
use App\Infrastructure\Request\ActionRequest;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use DateTime;
use PHPUnit\Framework\TestCase;

class ReinsureBookingsContext extends TestCase implements Context
{
    private const DATETIME_FORMAT = 'Y-m-d';

    private BookingsRepositoryInterface $bookingsRepository;

    private array $bookings;

    private ActionRequest $actionRequest;

    private ProcessActionUseCase $processActionUseCase;

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

        $this->processActionUseCase = new ProcessActionUseCase(
            new GetBookingService($this->bookingsRepository),
            new ValidateActionService($this->createMock(ActionsRepositoryInterface::class)),
            new CreateInsuranceService(
                $this->createMock(InsurancesRepositoryInterface::class),
                $this->bookingsRepository
            ),
            new CancelBookingsService($this->bookingsRepository)
        );
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
     * @When A modification arrives
     */
    public function aModificationArrives(TableNode $table): void
    {
        /** @var array<array-key,string> $row */
        foreach ($table as $row) {
            /** @var DateTime $checkIn */
            $checkIn = DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkIn']);
            /** @var DateTime $checkOut */
            $checkOut = DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkOut']);

            $action = match ($row['action']) {
                ActionEnum::Modification->name => ActionEnum::Modification,
                ActionEnum::Cancellation->name => ActionEnum::Cancellation,
                default => ActionEnum::Confirmation
            };

            $this->actionRequest = new ActionRequest(
                $row['reference'],
                $action,
                $checkIn,
                $checkOut,
                (int) $row['people']
            );
        }
    }

    /**
     * @Then Reinsure the booking with the newer information
     */
    public function reinsureTheBookingWithTheNewerInformation(): void
    {
        $exception = null;

        try {
            $this->processActionUseCase->__invoke($this->actionRequest);
        } catch (ErrorException | ValidationException $e) {
            $exception = $e;
        }

        $booking = $this->bookingsRepository->get($this->actionRequest->getReference());

        self::assertNotNull($booking);
        self::assertNull($exception);
        self::assertEquals(
            $this->actionRequest->getCheckIn()->format(self::DATETIME_FORMAT),
            $booking->getCheckIn()->format(self::DATETIME_FORMAT)
        );
        self::assertEquals(
            $this->actionRequest->getCheckOut()->format(self::DATETIME_FORMAT),
            $booking->getCheckOut()->format(self::DATETIME_FORMAT)
        );
        self::assertEquals($this->actionRequest->getPeople(), $booking->getPeople());
    }
}
