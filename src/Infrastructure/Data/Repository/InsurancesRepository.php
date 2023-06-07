<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Repository;

use App\Domain\Insurances\Ports\InsurancesDTOInterface;
use App\Domain\Insurances\Ports\InsurancesRepositoryInterface;
use App\Infrastructure\Data\Entity\Bookings;
use App\Infrastructure\Data\Entity\Insurances;
use Doctrine\ORM\EntityRepository;

/**
 * @template-extends EntityRepository<Insurances>
 */
class InsurancesRepository extends EntityRepository implements InsurancesRepositoryInterface
{
    public function save(InsurancesDTOInterface $insurance): bool
    {
        $bookingRepository = $this->_em->getRepository(Bookings::class);
        $bookingEntity     = $bookingRepository->findOneBy(['reference' => $insurance->getReference()]);

        $insuranceEntity = new Insurances();
        $insuranceEntity->setPolicy($insurance->getPolicy() ?? '')
            ->setPremiumAmount($insurance->premiumAmount())
            ->setBooking($bookingEntity);

        $this->_em->persist($insuranceEntity);

        $this->_em->flush();

        return true;
    }
}
