<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use App\Models\Vacancy;

final class ApplicationPolicy
{
    public function viewAny(User $user, ?Vacancy $vacancy = null): bool
    {
        return true;
    }

    public function view(User $user, Application $application, ?Vacancy $vacancy = null): bool
    {
        if ($user->role->isAdmin()) {
            return true;
        }

        if ($user->role->isEmployer()) {
            $employer = $application->loadMissing('vacancy.company.employer')->vacancy->company->employer;
            return $employer->is($user->userable);
        }

        $application = $application->loadMissing('apprentice');
        return $application->apprentice->is($user->userable);
    }

    public function create(User $user, ?Vacancy $vacancy = null): bool
    {
        return $user->role->is(['admin', 'apprentice']);
    }

    public function update(User $user, Application $application, ?Vacancy $vacancy = null): bool
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

    public function delete(User $user, Application $application, ?Vacancy $vacancy = null): bool
    {
        return $user->role->isAdmin();
    }

    public function restore(User $user, Application $application, ?Vacancy $vacancy = null): bool
    {
        return $user->role->isAdmin();
    }

    public function forceDelete(User $user, Application $application, ?Vacancy $vacancy = null): bool
    {
        return false;
    }
}
