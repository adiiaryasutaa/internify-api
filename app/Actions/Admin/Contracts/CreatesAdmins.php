<?php

declare(strict_types=1);

namespace App\Actions\Admin\Contracts;

interface CreatesAdmins
{
    public function create(array $inputs);
}
