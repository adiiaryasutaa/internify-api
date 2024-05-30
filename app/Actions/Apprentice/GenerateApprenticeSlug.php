<?php

declare(strict_types=1);

namespace App\Actions\Apprentice;

use App\Actions\Apprentice\Contracts\GeneratesApprenticesSlugs;
use Illuminate\Support\Str;

final class GenerateApprenticeSlug implements GeneratesApprenticesSlugs
{
    public function generate(?string $name = null): string
    {
        return str($name ?? Str::random())->lower()->slug()->toString();
    }
}
