<?php

declare(strict_types=1);

namespace App\Infrastructure\Data\Repository;

use App\Domain\Insurances\Ports\InsurancesDTOInterface;
use App\Domain\Insurances\Ports\InsurancesRepositoryInterface;
use App\Infrastructure\Data\Entity\Insurances;
use Doctrine\ORM\EntityRepository;

/**
 * @template-extends EntityRepository<Insurances>
 */
class InsurancesRepository extends EntityRepository implements InsurancesRepositoryInterface
{
    public function save(InsurancesDTOInterface $insurance): bool
    {
        $insuranceEntity = new Insurances();
        $insuranceEntity->setPolicy($insurance->getPolicy() ?? '')
            ->setPremiumAmount($insurance->premiumAmount());

        $this->_em->persist($insuranceEntity);

        $this->_em->flush();

        return true;
    }
}
