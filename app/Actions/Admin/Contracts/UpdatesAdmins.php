<?php

declare(strict_types=1);

namespace App\Actions\Admin\Contracts;

use App\Models\Admin;

interface UpdatesAdmins
{
    public function update(Admin $admin, array $inputs);
}
