<?php

declare(strict_types=1);

namespace App\Actions\Employer\Contracts;

interface GeneratesEmployersSlugs
{
    public function generate(?string $name): string;
}
