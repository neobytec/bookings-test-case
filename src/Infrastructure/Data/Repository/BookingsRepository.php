<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Repository;

use App\Domain\Bookings\Ports\BookingDTOInterface;
use App\Domain\Bookings\Ports\BookingsRepositoryInterface;
use App\Infrastructure\Data\Entity\Bookings;
use DateTime;
use Doctrine\ORM\EntityRepository;

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
        $bookingEntity = new Bookings();
        $bookingEntity->setReference($booking->getReference())
            ->setCheckIn($booking->getCheckIn())
            ->setCheckOut($booking->getCheckOut())
            ->setPeople($booking->getPeople())
            ->setModifiedAt(new DateTime());

        $this->_em->persist($bookingEntity);

        $this->_em->flush();

        return true;
    }
}
