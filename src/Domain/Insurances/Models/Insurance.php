<?php

declare(strict_types=1);

namespace App\Domain\Insurances\Models;

use App\Domain\Insurances\Ports\InsurancesDTOInterface;

class Insurance implements InsurancesDTOInterface
{
    public function __construct(
        private readonly float $premiumAmount,
        private readonly ?string $policy = null,
        private readonly ?string $reference = null,
    ) {
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getPolicy(): ?string
    {
        return $this->policy;
    }

    public function premiumAmount(): float
    {
        return $this->premiumAmount;
    }
}
