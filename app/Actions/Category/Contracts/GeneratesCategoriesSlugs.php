<?php

declare(strict_types=1);

namespace App\Actions\Category\Contracts;

interface GeneratesCategoriesSlugs
{
    public function generate(string $name);
}
