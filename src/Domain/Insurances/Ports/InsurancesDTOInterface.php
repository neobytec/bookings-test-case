<?php

declare(strict_types=1);

namespace App\Domain\Insurances\Ports;

interface InsurancesDTOInterface
{
    public function getReference(): ?string;

    public function getPolicy(): ?string;

    public function premiumAmount(): float;
}
