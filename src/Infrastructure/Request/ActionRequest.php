<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Domain\Actions\Models\ActionEnum;
use App\Domain\Actions\Ports\ActionDTOInterface;
use DateTime;

class ActionRequest implements ActionDTOInterface
{
    public function __construct(
        private readonly string $reference,
        private readonly ActionEnum $action,
        private readonly DateTime $checkIn,
        private readonly DateTime $checkOut,
        private readonly int $people,
    ) {}


    public function getReference(): string
    {
        return $this->reference;
    }

    public function getAction(): ActionEnum
    {
        return $this->action;
    }

    public function getCheckIn(): DateTime
    {
        return $this->checkIn;
    }

    public function getCheckOut(): DateTime
    {
        return $this->checkOut;
    }

    public function getPeople(): int
    {
        return $this->people;
    }
}