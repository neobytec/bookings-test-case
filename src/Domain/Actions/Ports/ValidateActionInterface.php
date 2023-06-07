<?php

declare(strict_types=1);

namespace App\Domain\Actions\Ports;

interface ValidateActionInterface
{
    public function __invoke(ActionDTOInterface $action): bool;
}
