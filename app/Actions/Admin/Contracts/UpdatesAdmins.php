<?php

namespace App\Actions\Admin\Contracts;

use App\Models\Admin;

interface UpdatesAdmins
{
    public function update(Admin $admin, array $inputs);
}
