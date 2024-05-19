<?php

namespace App\Enums;

use App\Enums\Concerns\HasChecker;
use App\Enums\Concerns\HasLabel;

enum ApplicationStatus: int
{
    use HasChecker, HasLabel;

    case PENDING = 1;
    case REVIEWED = 2;
    case REJECTED = 3;
    case ACCEPTED = 4;
}
