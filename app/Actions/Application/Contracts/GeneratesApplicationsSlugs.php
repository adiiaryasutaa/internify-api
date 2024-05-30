<?php

declare(strict_types=1);

namespace App\Actions\Application\Contracts;

interface GeneratesApplicationsSlugs
{
    public function generate(): string;
}
