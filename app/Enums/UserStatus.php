<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasChecker;
use App\Enums\Concerns\HasLabel;

enum UserStatus: int
{
    use HasChecker;
    use HasLabel;

    case ACTIVE = 1;
    case DISABLED = 2;
}
