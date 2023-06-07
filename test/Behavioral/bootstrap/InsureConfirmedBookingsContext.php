<?php

declare(strict_types=1);

namespace AppTest\Behavioral\bootstrap;

use App\Application\Actions\UseCases\ProcessActionUseCase;
use App\Domain\Actions\Models\ActionEnum;
use App\Domain\Actions\Ports\ActionsRepositoryInterface;
use App\Domain\Actions\Services\ProcessActionService;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Domain\Bookings\Services\GetBookingService;
use App\Domain\Exceptions\ErrorException;
use App\Domain\Exceptions\ValidationException;
use App\Domain\Insurances\Ports\InsurancesRepositoryInterface;
use App\Domain\Insurances\Services\CreateInsuranceService;
use App\Infrastructure\Request\ActionRequest;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Imbo\BehatApiExtension\Context\ApiContext;
use PHPUnit\Framework\TestCase;

class InsureConfirmedBookingsContext extends TestCase implements Context
{
    private const DATETIME_FORMAT = 'Y-m-d';

    private BookingsRepositoryInterface $bookingsRepository;

    private array $bookings;

    private ActionRequest $actionRequest;

    private ProcessActionUseCase $processActionUseCase;

    /** @BeforeScenario  */
    public function before() {
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
            new ProcessActionService($this->createMock(ActionsRepositoryInterface::class)),
            new CreateInsuranceService($this->createMock(InsurancesRepositoryInterface::class))
        );
    }

    /**
     * @Given A booking
     */
    public function aBooking(TableNode $table): void
    {
        foreach ($table as $row) {
            $status = match($row['status']) {
                BookingStatusEnum::NotInsured->name => BookingStatusEnum::NotInsured,
                BookingStatusEnum::Insured->name => BookingStatusEnum::Insured,
                BookingStatusEnum::Cancelled->name => BookingStatusEnum::Cancelled,
            };

            $checkIn = \DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkIn']);
            $checkOut = \DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkOut']);

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
     * @When A confirmation arrives
     */
    public function aConfirmationArrives(TableNode $table): void
    {
        foreach ($table as $row) {

            $checkIn = \DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkIn']);
            $checkOut = \DateTime::createFromFormat(self::DATETIME_FORMAT, $row['checkOut']);

            $action = match($row['action']) {
                ActionEnum::Confirmation->name => ActionEnum::Confirmation,
                ActionEnum::Modification->name => ActionEnum::Modification,
                ActionEnum::Cancellation->name => ActionEnum::Cancellation,
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
     * @Then Insure the booking
     */
    public function insureTheBooking(): void
    {
        $exception = null;

        try {
            $this->processActionUseCase->__invoke($this->actionRequest);
        } catch (ErrorException|ValidationException $e) {
            $exception = $e;
        }

        self::assertNull($exception);
    }
}
