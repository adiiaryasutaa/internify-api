<?php

namespace App\Actions\Auth;

use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Actions\Auth\Contracts\RegistersUsers;
use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Actions\User\Contracts\CreatesUsers;
use App\Enums\Role;
use App\Exceptions\AdminCannotRegisteredPubliclyException;
use App\Models\Apprentice;
use App\Models\Employer;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;

class RegisterUser implements RegistersUsers
{
    public function __construct(protected Application $app)
    {
    }

    /**
     * @throws AdminCannotRegisteredPubliclyException
     */
    public function register(array $inputs): User
    {
        $userData = Arr::only($inputs, ['name', 'username', 'email', 'password', 'role']);
        $userData['role'] = Role::tryFrom($userData['role']);
        Arr::forget($inputs, ['name', 'username', 'email', 'password', 'role']);

        $userable = match ($userData['role']) {
            Role::ADMIN => throw new AdminCannotRegisteredPubliclyException(),
            Role::EMPLOYER => $this->app[CreatesEmployers::class]->create($inputs),
            Role::APPRENTICE => $this->app[CreatesApprentices::class]->create($inputs),
        };

        $userCreator = $this->app[CreatesUsers::class];

        return match ($userData['role']) {
            Role::EMPLOYER => $userCreator->createForEmployer($userable, $userData),
            Role::APPRENTICE => $userCreator->createForApprentice($userable, $userData),
        };
    }
}
