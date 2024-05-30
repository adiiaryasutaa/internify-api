<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Apprentice;
use App\Models\User;

final class ApprenticePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function view(User $user, Apprentice $apprentice): bool
    {
        return $user->role->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->role->isAdmin();
    }

    public function update(User $user, Apprentice $apprentice): bool
    {
        return $user->role->isAdmin();
    }

    public function delete(User $user, Apprentice $apprentice): bool
    {
        return $user->role->isAdmin();
    }

    public function restore(User $user, Apprentice $apprentice): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Apprentice $apprentice): bool
    {
        return false;
    }
}
