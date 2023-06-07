<?php

declare(strict_types=1);

namespace App\Domain\Actions\Services;

use App\Domain\Actions\Ports\ActionDTOInterface;
use App\Domain\Actions\Ports\ActionsRepositoryInterface;
use App\Domain\Actions\Ports\ProcessActionInterface;
use App\Domain\Exceptions\ValidationException;

class ProcessActionService implements ProcessActionInterface
{
    public function __construct(
        private readonly ActionsRepositoryInterface $actionsRepository,
    ) {
    }

    public function __invoke(ActionDTOInterface $action): bool
    {
        $this->validate($action);
        return $this->actionsRepository->save($action);
    }

    private function validate(ActionDTOInterface $action): void
    {
        if ($action->getCheckIn() >= $action->getCheckOut()) {
            throw ValidationException::create('The date of check in must be lower than checkout');
        }

        if ($action->getPeople() < 1) {
            throw ValidationException::create('The people must be at least 1');
        }
    }
}
