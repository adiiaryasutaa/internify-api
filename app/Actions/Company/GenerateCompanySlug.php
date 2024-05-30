<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Actions\Company\Contracts\GeneratesCompaniesSlugs;
use Illuminate\Support\Str;

final class GenerateCompanySlug implements GeneratesCompaniesSlugs
{
    public function generate(?string $name = null): string
    {
        return str($name)->lower()->slug()->toString();
    }
}
