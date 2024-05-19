<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;

class AdminPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Admin $admin): bool
    {
        return $user->role->iaAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->isAdmin() && $user->userable->is_owner;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Admin $admin): bool
    {
        return $user->role->isAdmin() && $user->userable->is_owner;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Admin $admin): bool
    {
        return $user->role->isAdmin() && $user->userable->is_owner;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Admin $admin): bool
    {
        return $user->role->isAdmin() && $user->userable->is_owner;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Admin $admin): bool
    {
        return false;
    }
}
