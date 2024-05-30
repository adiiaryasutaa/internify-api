<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\GeneratesAdminsCodes;

final class GenerateAdminsCode implements GeneratesAdminsCodes
{
    public function generate(): string
    {
        return fake()->numerify('AD##########');
    }
}
