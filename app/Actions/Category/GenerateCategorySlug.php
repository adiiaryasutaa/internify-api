<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Contracts\GeneratesCategoriesSlugs;

final class GenerateCategorySlug implements GeneratesCategoriesSlugs
{
    public function generate(string $name): string
    {
        return str($name)->lower()->slug()->toString();
    }
}
