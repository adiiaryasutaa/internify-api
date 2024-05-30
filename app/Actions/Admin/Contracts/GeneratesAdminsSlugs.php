<?php

declare(strict_types=1);

namespace App\Actions\Admin\Contracts;

interface GeneratesAdminsSlugs
{
    public function generate(?string $name): string;
}
