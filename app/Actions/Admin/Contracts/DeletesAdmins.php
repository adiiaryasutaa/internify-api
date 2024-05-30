<?php

declare(strict_types=1);

namespace App\Actions\Admin\Contracts;

use App\Models\Admin;

interface DeletesAdmins
{
    public function delete(Admin $admin);
}
