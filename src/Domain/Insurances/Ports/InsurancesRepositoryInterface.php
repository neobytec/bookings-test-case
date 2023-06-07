<?php

declare(strict_types=1);

namespace App\Domain\Insurances\Ports;

interface InsurancesRepositoryInterface
{
    public function save(InsurancesDTOInterface $insurance): bool;
}
