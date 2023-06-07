<?php

declare(strict_types=1);

namespace App\Domain\Actions\Ports;

use App\Domain\Actions\Models\ActionEnum;
use DateTime;

interface ActionDTOInterface
{
    public function getReference(): string;

    public function getAction(): ActionEnum;

    public function getCheckIn(): DateTime;

    public function getCheckOut(): DateTime;

    public function getPeople(): int;
}
