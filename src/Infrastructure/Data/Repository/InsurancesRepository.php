<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Repository;

use App\Domain\Insurances\Ports\InsurancesDTOInterface;
use App\Domain\Insurances\Ports\InsurancesRepositoryInterface;
use App\Infrastructure\Data\Entity\Bookings;
use App\Infrastructure\Data\Entity\Insurances;
use Doctrine\ORM\EntityRepository;
use Exception;

use function random_int;
use function str_pad;

use const STR_PAD_LEFT;

/**
 * @template-extends EntityRepository<Insurances>
 */
class InsurancesRepository extends EntityRepository implements InsurancesRepositoryInterface
{
    public function save(InsurancesDTOInterface $insurance): bool
    {
        $bookingRepository = $this->_em->getRepository(Bookings::class);
        $bookingEntity     = $bookingRepository->findOneBy(['reference' => $insurance->getReference()]);

        try {
            $policy = $insurance->getPolicy() ?? $insurance->getReference()
                . str_pad((string) random_int(0, 999), 3, '0', STR_PAD_LEFT);
        } catch (Exception) {
            return false;
        }

        $insuranceEntity = new Insurances();
        $insuranceEntity->setPolicy($policy)
            ->setPremiumAmount($insurance->premiumAmount())
            ->setBooking($bookingEntity);

        $this->_em->persist($insuranceEntity);

        $this->_em->flush();

        return true;
    }
}
