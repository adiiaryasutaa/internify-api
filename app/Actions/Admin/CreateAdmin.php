<?php

namespace App\Actions\Admin;

use App\Actions\Admin\Contracts\CreatesAdmins;
use App\Actions\User\Contracts\CreatesUsers;
use App\Enums\Role;
use App\Exceptions\CreateAdminWithoutUserException;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CreateAdmin implements CreatesAdmins
{
    public function __construct(protected CreatesUsers $userCreator)
    {
    }

    public function create(array $inputs): Admin
    {
        return DB::transaction(function () use ($inputs) {
            $userData = Arr::only($inputs, ['avatar', 'name', 'username', 'email', 'password']);
            Arr::forget($inputs, ['avatar', 'name', 'username', 'email', 'password']);
            $userData['role'] = Role::ADMIN;

            throw_unless($userData, CreateAdminWithoutUserException::class);

            return tap(Admin::create($inputs), fn(Admin $admin) => $this->userCreator->createForAdmin($admin, $userData)
            );
        });
    }
}
