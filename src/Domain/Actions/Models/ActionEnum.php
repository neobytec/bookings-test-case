<?php

declare(strict_types=1);

namespace App\Domain\Actions\Models;

enum ActionEnum: int
{
    case Confirmation = 1;
    case Modification = 2;
    case Cancellation = 3;
}
