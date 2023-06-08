<?php

declare(strict_types=1);

namespace App\Infrastructure\Handler;

use App\Application\Bookings\UseCases\ListInsuredBookingsUseCase;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListInsuredBookingsHandler implements RequestHandlerInterface
{
    private const DATETIME_FORMAT = 'Y-m-d';

    public function __construct(
        private readonly ListInsuredBookingsUseCase $listInsuredBookingsUseCase
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $insuredList = $this->listInsuredBookingsUseCase->__invoke();

        return new JsonResponse($this->toArray($insuredList), 200);
    }

    private function toArray(array $bookings): array
    {
        $result = [];
        /** @var BookingDTOInterface $booking */
        foreach ($bookings as $booking) {
            $result[] = [
                'reference'      => $booking->getReference(),
                'check_in'       => $booking->getCheckIn()->format(self::DATETIME_FORMAT),
                'check_out'      => $booking->getCheckOut()->format(self::DATETIME_FORMAT),
                'people'         => $booking->getPeople(),
                'premium_amount' => $booking->getPremiumAmount(),
            ];
        }

        return $result;
    }
}
