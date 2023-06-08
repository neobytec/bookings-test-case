<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Repository;

use App\Domain\Bookings\Models\BookingStatusEnum;
use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Infrastructure\Data\Entity\Bookings;
use DateTime;
use Doctrine\ORM\EntityRepository;
use Exception;

/**
 * @template-extends EntityRepository<Bookings>
 */
class BookingsRepository extends EntityRepository implements BookingsRepositoryInterface
{
    public function get(string $reference): ?BookingDTOInterface
    {
        return $this->findOneBy(['reference' => $reference]);
    }

    public function save(BookingDTOInterface $booking): bool
    {
        $bookingEntity = $this->findOneBy(['reference' => $booking->getReference()]);
        if (! $bookingEntity) {
            $bookingEntity = new Bookings();
        }

        $status = 0;
        if ($booking->isInsured()) {
            $status = BookingStatusEnum::Insured->value;
        }

        if ($booking->isCancelled()) {
            $status = BookingStatusEnum::Cancelled->value;
        }

        $bookingEntity->setReference($booking->getReference())
            ->setCheckIn($booking->getCheckIn())
            ->setCheckOut($booking->getCheckOut())
            ->setPeople($booking->getPeople())
            ->setStatus($status)
            ->setModifiedAt(new DateTime());

        $this->_em->persist($bookingEntity);

        try {
            $this->_em->flush();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function cancel(BookingDTOInterface $booking): bool
    {
        $bookingEntity = $this->findOneBy(['reference' => $booking->getReference()]);
        if (! $bookingEntity) {
            return false;
        }

        $bookingEntity->setStatus(BookingStatusEnum::Cancelled->value);

        $this->_em->persist($bookingEntity);

        $this->_em->flush();

        return true;
    }

    public function getInsured(): array
    {
        return $this->findBy(['status' => BookingStatusEnum::Insured->value]);
    }

    public function getCancelled(): array
    {
        return $this->findBy(['status' => BookingStatusEnum::Cancelled->value]);
    }

    public function remove(string $reference): bool
    {
        $bookingEntity = $this->findOneBy(['reference' => $reference]);
        if (! $bookingEntity) {
            return false;
        }

        $this->_em->remove($bookingEntity);

        $this->_em->flush();

        return true;
    }
}
