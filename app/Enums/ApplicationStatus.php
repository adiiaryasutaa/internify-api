<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Concerns\HasChecker;
use App\Enums\Concerns\HasLabel;

/**
 * @method isPending()
 * @method isReviewed()
 * @method isRejected()
 * @method isAccepted()
 */
enum ApplicationStatus: int
{
    use HasChecker;
    use HasLabel;

    case PENDING = 1;
    case REVIEWED = 2;
    case REJECTED = 3;
    case ACCEPTED = 4;
}
