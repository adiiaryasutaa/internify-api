<?php

declare(strict_types=1);

namespace App\Actions\Apprentice\Contracts;

use App\Models\Apprentice;

interface DeletesApprentices
{
    public function delete(Apprentice $apprentice);
}
