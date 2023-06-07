<?php

declare(strict_types=1);

namespace App\Domain\Actions\Services;

use App\Domain\Actions\Ports\ActionDTOInterface;
use App\Domain\Actions\Ports\ActionsRepositoryInterface;
use App\Domain\Actions\Ports\ProcessActionInterface;

class ProcessActionService implements ProcessActionInterface
{
    public function __construct(
        private readonly ActionsRepositoryInterface $actionsRepository,
    ) {
    }

    public function __invoke(ActionDTOInterface $action): bool
    {
        return $this->actionsRepository->save($action);
    }
}
