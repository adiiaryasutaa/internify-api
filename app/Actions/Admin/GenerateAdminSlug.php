<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\GeneratesAdminsSlugs;
use Illuminate\Support\Str;

final class GenerateAdminSlug implements GeneratesAdminsSlugs
{
    public function generate(?string $name = null): string
    {
        return str($name ?? Str::random())->lower()->slug()->toString();
    }
}
