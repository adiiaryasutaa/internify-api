<?php

declare(strict_types=1);

namespace App\Actions\Employer;

use App\Actions\Employer\Contracts\GeneratesEmployersSlugs;
use Illuminate\Support\Str;

final class GenerateEmployerSlug implements GeneratesEmployersSlugs
{
    public function generate(?string $name = null): string
    {
        return str($name ?? Str::random())->lower()->slug()->toString();
    }
}
