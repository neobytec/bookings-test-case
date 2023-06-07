<?php

declare(strict_types=1);

namespace App\Domain\Actions\Ports;

interface ActionsRepositoryInterface
{
    public function save(ActionDTOInterface $action): bool;
}
