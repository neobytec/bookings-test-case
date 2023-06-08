<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Repository;

use App\Domain\Actions\Ports\ActionDTOInterface;
use App\Domain\Actions\Ports\ActionsRepositoryInterface;
use App\Infrastructure\Data\Entity\Actions;
use App\Infrastructure\Data\Entity\Bookings;
use DateTime;
use Doctrine\ORM\EntityRepository;

/**
 * @template-extends EntityRepository<Actions>
 */
class ActionsRepository extends EntityRepository implements ActionsRepositoryInterface
{
    public function save(ActionDTOInterface $action): bool
    {
        $actionEntity = new Actions();
        $actionEntity->setAction($action->getAction()->value)
            ->setCheckIn($action->getCheckIn())
            ->setCheckOut($action->getCheckOut())
            ->setPeople($action->getPeople())
            ->setCreatedAt(new DateTime())
            ->setBooking($this->getBooking($action->getReference()));

        $this->_em->persist($actionEntity);

        $this->_em->flush();

        return true;
    }

    private function getBooking(string $reference): ?Bookings
    {
        $bookingsRepository = $this->_em->getRepository(Bookings::class);
        return $bookingsRepository->findOneBy(['reference' => $reference]);
    }
}
