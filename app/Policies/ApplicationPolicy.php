<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

final class ApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Application $application): bool
    {
        if ($user->role->isAdmin()) {
            return true;
        }

        if ($user->role->isApprentice()) {
            $application = $application->loadMissing('apprentice');
            return $application->apprentice->is($user->userable);
        }

        $application = $application->loadMissing('company.employer');
        return $application->company->employer->is($user->userable);
    }

    public function create(User $user): bool
    {
        return $user->role->is(['admin', 'apprentice']);
    }

    public function update(User $user, Application $application): bool
    {
        if ($user->role->isAdmin()) {
            return true;
        }

        if ($user->role->isApprentice()) {
            $application = $application->loadMissing('apprentice');

            return $application->status->isPending() && $application->apprentice->is($user->userable);
        }

        return false;
    }

    public function delete(User $user, Application $application): bool
    {
        if ($user->role->isAdmin()) {
            return true;
        }

        if ($user->role->isEmployer()) {
            $application = $application->loadMissing('company.employer');
            return $application->company->employer->is($user->userable);
        }

        $application = $application->loadMissing('apprentice');
        return $application->status->isPending() && $application->apprentice->is($user->userable);
    }

    public function restore(User $user, Application $application): bool
    {
        return $user->role->isAdmin();
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }
}
