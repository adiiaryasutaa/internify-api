<?php

declare(strict_types=1);

namespace App\Actions\Apprentice\Contracts;

interface GeneratesApprenticesSlugs
{
    public function generate(?string $name): string;
}
