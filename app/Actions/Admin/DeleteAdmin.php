<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\DeletesAdmins;
use App\Actions\User\Contracts\DeletesUsers;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

final class DeleteAdmin implements DeletesAdmins
{
    public function __construct(protected DeletesUsers $userDeleter) {}

    public function delete(Admin $admin): bool
    {
        return DB::transaction(fn() => $admin->delete() && $this->userDeleter->delete($admin->user));
    }
}
