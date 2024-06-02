<?php

declare(strict_types=1);

namespace App\Actions\Category\Contracts;

interface CreatesCategories
{
    public function create(array $inputs);
}
