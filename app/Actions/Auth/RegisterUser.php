<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Actions\Auth\Contracts\RegistersUsers;
use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Enums\Role;
use App\Exceptions\AdminCannotRegisteredPubliclyException;
use App\Models\Apprentice;
use App\Models\Employer;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;

final class RegisterUser implements RegistersUsers
{
    public function __construct(protected Application $app) {}

    /**
     * @throws AdminCannotRegisteredPubliclyException
     */
    public function register(array $inputs): Employer|Apprentice
    {
        $data = Arr::only($inputs, ['name', 'username', 'email', 'password', 'role']);

        return match (Role::tryFrom($data['role'])) {
            Role::ADMIN => throw new AdminCannotRegisteredPubliclyException(),
            Role::EMPLOYER => $this->app[CreatesEmployers::class]->create($data),
            Role::APPRENTICE => $this->app[CreatesApprentices::class]->create($data),
        };
    }
}
