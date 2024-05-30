<?php

declare(strict_types=1);

namespace App\Actions\Company\Contracts;

interface GeneratesCompaniesSlugs
{
    public function generate(?string $name);
}
