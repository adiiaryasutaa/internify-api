<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Contracts\GeneratesCategoriesCodes;

final class GenerateCategoryCode implements GeneratesCategoriesCodes
{
    public function generate(): string
    {
        return fake()->numerify('CA##########');
    }
}
