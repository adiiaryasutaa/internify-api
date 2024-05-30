<?php

declare(strict_types=1);

namespace App\Actions\Apprentice\Contracts;

use App\Models\Apprentice;

interface UpdatesApprentices
{
    public function update(Apprentice $apprentice, array $inputs);
}
