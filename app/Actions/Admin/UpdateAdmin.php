<?php

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\UpdatesAdmins;
use App\Exceptions\HasNoUserException;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateAdmin implements UpdatesAdmins
{
    public function update(Admin $admin, array $inputs): bool
    {
        return DB::transaction(function () use ($admin, $inputs) {
            $user = Arr::pull($inputs, 'user', []);

            throw_if($user && ! $admin->user, HasNoUserException::class);

            return $admin->update($inputs) && ($user && $admin->user?->update($user));
        });
    }
}
