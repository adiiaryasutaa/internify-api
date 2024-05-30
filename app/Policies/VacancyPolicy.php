<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Vacancy;

final class VacancyPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Vacancy $vacancy): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role->is(['admin', 'employer']);
    }

    public function update(User $user, Vacancy $vacancy): bool
    {
        $vacancy = $vacancy->loadMissing('company.employer');

        if ($user->role->isAdmin()) {
            return true;
        }

        return $vacancy->company->employer->is($user->userable);
    }

    public function delete(User $user, Vacancy $vacancy): bool
    {
        return $this->update($user, $vacancy);
    }

    public function restore(User $user, Vacancy $vacancy): bool
    {
        return $user->role->isAdmin();
    }

    public function forceDelete(User $user, Vacancy $vacancy): bool
    {
        return false;
    }
}
