<?php

namespace App\Enums;

use App\Enums\Concerns\HasChecker;
use App\Enums\Concerns\HasLabel;

enum UserStatus: int
{
    use HasChecker, HasLabel;

    case ACTIVE = 1;
    case DISABLED = 2;
}
