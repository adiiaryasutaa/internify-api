<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Employer;
use App\Models\User;

final class EmployerPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function view(User $user, Employer $employer): bool
    {
        return $user->role->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function update(User $user, Employer $employer): bool
    {
        return $user->role->isAdmin();
    }

    public function delete(User $user, Employer $employer): bool
    {
        return $user->role->isAdmin();
    }

    public function restore(User $user, Employer $employer): bool
    {
        return $user->role->isAdmin();
    }

    public function forceDelete(User $user, Employer $employer): bool
    {
        return false;
    }
}
