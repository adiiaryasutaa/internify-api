<?php

declare(strict_types=1);

namespace App\Actions\Application;

use App\Actions\Application\Contracts\GeneratesApplicationsSlugs;
use Illuminate\Support\Str;

final class GenerateApplicationSlug implements GeneratesApplicationsSlugs
{
    public function generate(): string
    {
        return str(Str::random())->lower()->slug()->toString();
    }
}
