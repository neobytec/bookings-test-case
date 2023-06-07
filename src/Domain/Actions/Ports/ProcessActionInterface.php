<?php

declare(strict_types=1);

namespace App\Domain\Actions\Ports;

interface ProcessActionInterface
{
    public function __invoke(ActionDTOInterface $action): bool;
}
