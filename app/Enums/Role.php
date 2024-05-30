<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasChecker;
use App\Enums\Concerns\HasLabel;

enum Role: int
{
    use HasChecker;
    use HasLabel;

    case ADMIN = 1;
    case EMPLOYER = 2;
    case APPRENTICE = 3;
}
