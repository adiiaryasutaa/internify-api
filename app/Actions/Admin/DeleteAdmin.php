<?php

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\DeletesAdmins;
use App\Models\Admin;

class DeleteAdmin implements DeletesAdmins
{
    public function delete(Admin $admin): bool
    {
        return (! $admin->user || $admin->user->delete()) && $admin->delete();
    }
}
